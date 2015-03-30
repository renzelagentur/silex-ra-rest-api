<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 26.03.15
 * Time: 14:50
 */

namespace RA\SilexRestApi\Query;


use RA\SilexRestApi\Filter\FilterInterface;

interface QueryInterface {

    public function setFields(array $fields);

    public function setFilter(FilterInterface $filter);

    public function generate();

} 