<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 26.03.15
 * Time: 12:02
 */

namespace RA\SilexRestApi\Filter\Constraint;


use RA\SilexRestApi\Filter\ConstraintInterface;
use RA\SilexRestApi\Filter\LogicalConstraintInterface;

abstract class AbstractLogicalConstraint implements LogicalConstraintInterface {

    protected $constraints;

    public function __construct() {
        $numArgs = func_num_args();
        if ($numArgs > 0) {
            $argList = func_get_args();
            for ($i = 0; $i < $numArgs; $i++) {
                if ($argList[$i] instanceof ConstraintInterface) {
                    $this->addConstraint($argList[$i]);
                }
            }
        }
    }

    /**
     * Adds a constraint
     *
     * @param ConstraintInterface $constraint
     *
     */
    public function addConstraint(ConstraintInterface $constraint)
    {
        $this->constraints[] = $constraint;
    }

    /**
     * Returns all constraints
     *
     * @return ConstraintInterface[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

} 