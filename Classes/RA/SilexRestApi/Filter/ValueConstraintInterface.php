<?php

namespace RA\SilexRestApi\Filter;

/**
 * A value constraint, is a constraint, that compares a field to a value in a defined way
 *
 * @package RA\SilexRestApi\Filter
 */
interface ValueConstraintInterface extends ConstraintInterface {

    /**
     * Setter for the name of the field, the constrain is applied to
     *
     * @param $fieldName
     *
     * @return void
     */
    public function setFieldName($fieldName);

    /**
     * Getter for the name of the field, the constrain is applied to
     *
     * @return string
     */
    public function getFieldName();

    /**
     * Set the value which is used by the constrain
     *
     * @param $value
     *
     * @return void
     */
    public function setFieldValue($value);

    /**
     * Get the value which is used by the constrain
     *
     * @param $value
     *
     * @return mixed
     */
    public function getFieldValue();

} 