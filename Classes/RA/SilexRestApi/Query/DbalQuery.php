<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 26.03.15
 * Time: 15:32
 */

namespace RA\SilexRestApi\Query;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use RA\SilexRestApi\Filter\Constraint\Equals;
use RA\SilexRestApi\Filter\Constraint\GreaterThan;
use RA\SilexRestApi\Filter\Constraint\GreaterThanOrEquals;
use RA\SilexRestApi\Filter\Constraint\LessThan;
use RA\SilexRestApi\Filter\Constraint\LessThanOrEquals;
use RA\SilexRestApi\Filter\Constraint\Like;
use RA\SilexRestApi\Filter\Constraint\LogicalAnd;
use RA\SilexRestApi\Filter\Constraint\LogicalOr;
use RA\SilexRestApi\Filter\Constraint\NotEquals;
use RA\SilexRestApi\Filter\Constraint\NotLike;
use RA\SilexRestApi\Filter\ConstraintInterface;
use RA\SilexRestApi\Filter\FilterInterface;
use RA\SilexRestApi\Filter\LogicalConstraintInterface;

class DbalQuery implements QueryInterface {

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection, $tableName) {
        $this->queryBuilder = $connection->createQueryBuilder();
        $this->queryBuilder->from($tableName);
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields)
    {
        call_user_func(array($this->queryBuilder, 'select'), $fields);
    }

    /**
     * @param FilterInterface $filter
     */
    public function setFilter(FilterInterface $filter)
    {
        if ($filter->getRootConstraint() !== NULL) {
            $this->queryBuilder->where($this->convertConstraint($filter->getRootConstraint()));
        }
    }

    /**
     * @param int $itemsPerPage
     */
    public function setPagination($itemsPerPage = 0, $page = 0)
    {
        if ($itemsPerPage > 0) {
            $this->queryBuilder->setMaxResults($itemsPerPage);
        }

        if ($page > 1 && $itemsPerPage > 0) {
            $this->queryBuilder->setFirstResult(($page * $itemsPerPage) - $itemsPerPage);
        }
    }

    /**
     * Generates the query
     *
     * @return QueryBuilder
     */
    public function generate()
    {
        return $this->queryBuilder;
    }

    /**
     * Convert a constraint into a Doctrine DBAL constraint
     *
     * @param ConstraintInterface $constraint
     *
     * @return mixed
     */
    private function convertConstraint(ConstraintInterface $constraint) {
        if ($constraint instanceof Equals) {
            return $this->queryBuilder->expr()->eq($constraint->getFieldName(), $this->queryBuilder->createNamedParameter($constraint->getFieldValue()));
        }

        if ($constraint instanceof NotEquals) {
            return $this->queryBuilder->expr()->neq($constraint->getFieldName(), $this->queryBuilder->createNamedParameter($constraint->getFieldValue()));
        }

        if ($constraint instanceof Like) {
            return $this->queryBuilder->expr()->like($constraint->getFieldName(), $this->queryBuilder->createNamedParameter($constraint->getFieldValue()));
        }

        if ($constraint instanceof NotLike) {
            return $this->queryBuilder->expr()->notlike($constraint->getFieldName(), $this->queryBuilder->createNamedParameter($constraint->getFieldValue()));
        }

        if ($constraint instanceof GreaterThan) {
            return $this->queryBuilder->expr()->gt($constraint->getFieldName(), $this->queryBuilder->createNamedParameter($constraint->getFieldValue()));
        }

        if ($constraint instanceof GreaterThanOrEquals) {
            return $this->queryBuilder->expr()->gte($constraint->getFieldName(), $this->queryBuilder->createNamedParameter($constraint->getFieldValue()));
        }

        if ($constraint instanceof LessThan) {
            return $this->queryBuilder->expr()->lt($constraint->getFieldName(), $this->queryBuilder->createNamedParameter($constraint->getFieldValue()));
        }

        if ($constraint instanceof LessThanOrEquals) {
            return $this->queryBuilder->expr()->lte($constraint->getFieldName(), $this->queryBuilder->createNamedParameter($constraint->getFieldValue()));
        }

        if ($constraint instanceof LogicalConstraintInterface) {
            $subConstraints = $constraint->getConstraints();
            array_walk($subConstraints, function(&$element, $index) {$element = $this->convertConstraint($element);});

            if ($constraint instanceof LogicalAnd) {
                return  call_user_func_array(array($this->queryBuilder->expr(), 'andX'), $subConstraints);
            }

            if ($constraint instanceof LogicalOr) {
                return  call_user_func_array(array($this->queryBuilder->expr(), 'orX'), $subConstraints);
            }


        }
    }
}
