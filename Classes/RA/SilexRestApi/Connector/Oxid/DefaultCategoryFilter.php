<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 30.03.15
 * Time: 09:33
 */

namespace RA\SilexRestApi\Connector\Oxid;


use RA\SilexRestApi\Filter\Constraint\Like;
use RA\SilexRestApi\Filter\Constraint\LogicalOr;
use RA\SilexRestApi\Filter\Filter;

class DefaultCategoryFilter extends Filter {

    function __construct($search)
    {
        $constraint = new LogicalOr(
            new Like('OXTITLE', '%' . $search . '%'),
            new Like('OXDESC', '%' . $search . '%')
        );

        $this->setRootConstraint($constraint);
    }
}