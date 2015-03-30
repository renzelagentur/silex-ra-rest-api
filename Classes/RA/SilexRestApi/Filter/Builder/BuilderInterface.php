<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 27.03.15
 * Time: 10:18
 */

namespace RA\SilexRestApi\Filter\Builder;


use RA\SilexRestApi\Filter\FilterInterface;

interface BuilderInterface {

    /**
     * @return FilterInterface
     */
    public function build();

} 