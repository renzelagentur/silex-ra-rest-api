<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 26.03.15
 * Time: 12:23
 */

namespace RA\SilexRestApi\Filter\Constraint;


use RA\SilexRestApi\Filter\ValueConstraintInterface;

class AbstractValueConstraint implements ValueConstraintInterface {

    protected $fieldName;

    protected $fieldValue;

    public function __construct($fieldName, $fieldValue) {
        $this->setFieldName($fieldName);
        $this->setFieldValue($fieldValue);
    }

    /**
     * Setter for the name of the field, the constrain is applied to
     *
     * @param $fieldName
     *
     * @return void
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
    }

    /**
     * Getter for the name of the field, the constrain is applied to
     *
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * Set the value which is used by the constrain
     *
     * @param $value
     *
     * @return void
     */
    public function setFieldValue($value)
    {
        $this->fieldValue = $value;
    }

    /**
     * Get the value which is used by the constrain
     *
     * @param $value
     *
     * @return mixed
     */
    public function getFieldValue()
    {
        return $this->fieldValue;
    }
}