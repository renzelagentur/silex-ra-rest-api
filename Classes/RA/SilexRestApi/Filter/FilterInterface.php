<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 23.03.15
 * Time: 15:18
 */

namespace RA\SilexRestApi\Filter;


interface FilterInterface {

    public function setRootConstraint(ConstraintInterface $constraint);

    public function getRootConstraint();

    public function setPagination($itemsPerPage = 0, $page = 0);

    public function getItemsPerPage();

    public function getPage();

} 