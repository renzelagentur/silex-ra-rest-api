<?php

namespace RA\SilexRestApi\Stream;

/**
 * Interface, that describes an output stream
 *
 * @package RA\SilexRestApi\Stream
 */
interface StreamInterface {

    /**
     * Method being called when the stream starts
     */
    public function start();

    /**
     * Method being called, when a dataset is to be streamed
     * @param $row
     */
    public function streamRow($row);

    /**
     * Method being called when the stream is complete
     */
    public function finish();

} 