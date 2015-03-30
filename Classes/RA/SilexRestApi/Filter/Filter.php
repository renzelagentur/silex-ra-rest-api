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

    public function setRootConstraint(ConstraintInterface $constraint)
    {
        $this->constraint = $constraint;
    }

    public function getRootConstraint()
    {
        return $this->constraint;
    }
}