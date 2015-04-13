<?php

namespace RA\SilexRestApi\Filter\Builder;

use RA\SilexRestApi\Filter\Filter;
use RA\SilexRestApi\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestFilterBuilder implements BuilderInterface {

    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @return FilterInterface
     */
    public function build(FilterInterface $default = NULL)
    {
        if ($default !== NULL) {
            $filter = $default;
        } else {
            $filter = new Filter();
        }

        if ($this->request->get('filter') !== NULL) {
            // TODO: Implement stuff here.
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
}