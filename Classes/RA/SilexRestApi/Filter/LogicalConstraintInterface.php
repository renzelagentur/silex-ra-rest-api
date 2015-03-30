<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 26.03.15
 * Time: 11:50
 */

namespace RA\SilexRestApi\Filter;

/**
 * A Logical Constraint, is a Constraint that performs logical operations
 * like AND or OR on any amount of sub-constraints
 *
 * @package RA\SilexRestApi\Filter
 */
interface LogicalConstraintInterface extends ConstraintInterface {

    /**
     * Adds a constraint
     * @param ConstraintInterface $constraint
     *
     */
    public function addConstraint(ConstraintInterface $constraint);

    /**
     * Returns all constraints
     * @return ConstraintInterface[]
     */
    public function getConstraints();

} 