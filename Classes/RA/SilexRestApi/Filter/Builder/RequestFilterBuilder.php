<?php

namespace RA\SilexRestApi\Filter\Builder;

use RA\SilexRestApi\Filter\Constraint\Equals;
use RA\SilexRestApi\Filter\Constraint\GreaterThan;
use RA\SilexRestApi\Filter\Constraint\LessThan;
use RA\SilexRestApi\Filter\Constraint\LessThanOrEquals;
use RA\SilexRestApi\Filter\Constraint\Like;
use RA\SilexRestApi\Filter\Constraint\LogicalAnd;
use RA\SilexRestApi\Filter\Constraint\NotEquals;
use RA\SilexRestApi\Filter\Constraint\NotLike;
use RA\SilexRestApi\Filter\Filter;
use RA\SilexRestApi\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestFilterBuilder implements BuilderInterface {

    /**
     * @var array
     */
    private $constraints = ['!', '<', '>', '=', '%'];

    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @param FilterInterface|null $default
     *
     * @return Filter|FilterInterface
     */
    public function build(FilterInterface $default = NULL)
    {
        if ($default !== NULL) {
            $filter = $default;
        } else {
            $filter = new Filter();
        }

        $filter->setRequest($this->request);

        if ($this->request->get('filters')) {
            foreach ($this->request->get('filters') as $field => $value) {
                $condition = $this->getConditionByValue($value);
                $value = $this->getCleanValue($value);
                switch ($condition) {
                    case '!':
                            $fieldConstraint = new NotEquals($field, $value);
                        break;
                    case '<':
                            $fieldConstraint = new LessThan($field, $value);
                        break;
                    case '<=':
                            $fieldConstraint = new LessThanOrEquals($field, $value);
                        break;
                    case '>':
                            $fieldConstraint = new GreaterThan($field, $value);
                        break;
                    case '>=':
                            $fieldConstraint = new LessThanOrEquals($field, $value);
                        break;
                    case '%':
                            $fieldConstraint = new Like($field, $value);
                        break;
                    case '!%':
                            $fieldConstraint = new NotLike($field, $value);
                        break;
                    default:
                            $fieldConstraint = new Equals($field, $value);
                        break;
                }

                $constraint = new LogicalAnd();
                $constraint->addConstraint($fieldConstraint);

                $filter->setRootConstraint($constraint);
            }
        }

        if ($this->request->get('itemsPerPage') !== NULL) {
            $itemsPerPage = (int) $this->request->get('itemsPerPage');
        } else {
            $itemsPerPage = 0;
        }

        if ($this->request->get('page') !== NULL) {
            $page = (int) $this->request->get('page');
        } else {
            $page = 1;
        }

        $filter->setPagination($itemsPerPage, $page);

        return $filter;
    }

    /**
     * get clean value without any condition
     *
     * @param string $value
     *
     * @return string
     */
    private function getCleanValue($value)
    {
        $start = 0;
        foreach (str_split($value) as $char) {
            if (in_array($char, $this->constraints)) {
                $start++;
            }
        }

        return substr($value, $start);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function getConditionByValue($value)
    {
        $constraint = '';

        foreach (str_split($value) as $char) {
            if (in_array($char, $this->constraints)) {
                $constraint .= $char;
            } elseif (ctype_alnum($char)) {
                break;
            }
        }

        return $constraint;
    }
}