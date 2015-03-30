<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 24.03.15
 * Time: 09:05
 */

namespace RA\SilexRestApi\Container;

/**
 * This interface defines a data container, that can be used to wrap and pass arround data
 *
 * @package RA\SilexRestApi\Container
 */
interface ContainerInterface {

    /**
     * A setter for the contained data
     *
     * @param array $data
     *
     * @return mixed
     */
    public function setData(array $data);

    /**
     * A getter for the contained data
     *
     * @return mixed
     */
    public function getData();

    /**
     * Gets the primary identifier for the contained entity
     *
     * @return mixed
     */
    public function getIdentifier();

} 