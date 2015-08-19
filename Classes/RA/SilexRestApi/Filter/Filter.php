<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 27.03.15
 * Time: 08:28
 */

namespace RA\SilexRestApi\Filter;


use Symfony\Component\HttpFoundation\Request;

class Filter implements FilterInterface {

    private $constraint;

    private $itemsPerPage;

    private $page;

    private $request;

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

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }


}