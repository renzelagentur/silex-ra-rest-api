<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 23.03.15
 * Time: 15:18
 */

namespace RA\SilexRestApi\Filter;


use Symfony\Component\HttpFoundation\Request;

interface FilterInterface {

    public function setRequest(Request $request);

    public function getRequest();

    public function setRootConstraint(ConstraintInterface $constraint);

    public function getRootConstraint();

    public function setPagination($itemsPerPage = 0, $page = 0);

    public function getItemsPerPage();

    public function getPage();

} 