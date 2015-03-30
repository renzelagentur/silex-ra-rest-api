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
    public function build()
    {
        $filter = new Filter();

        if ($this->request->get('filter') !== NULL) {

        } else {
            return null;
        }
    }
}