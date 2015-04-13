<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 27.03.15
 * Time: 08:28
 */

namespace RA\SilexRestApi\Filter;


class Filter implements FilterInterface {

    private $constraint;

    private $itemsPerPage;

    private $page;

    public function setRootConstraint(ConstraintInterface $constraint)
    {
        $this->constraint = $constraint;
    }

    public function getRootConstraint()
    {
        return $this->constraint;
    }

    public function setPagination($itemsPerPage = 0, $page = 0)
    {
        $this->itemsPerPage = $itemsPerPage;
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }


}