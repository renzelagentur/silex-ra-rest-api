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

    /**
     * Constructor that can take a variable amount of Constraints either as parameter list or as a single array
     */
    public function __construct() {
        $numArgs = func_num_args();
        if ($numArgs == 1) {
            $argList = func_get_args();
            if (is_array($argList[0])) {
                foreach ($argList[0] as $arg) {
                    if ($arg instanceof ConstraintInterface) {
                        $this->addConstraint($arg);
                    }
                }

                // When we used an array of arguments, further checks are no longer necessary
                return;
            }
        }

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