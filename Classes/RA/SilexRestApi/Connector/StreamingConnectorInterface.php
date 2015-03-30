<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 25.03.15
 * Time: 09:34
 */

namespace RA\SilexRestApi\Connector;

use RA\SilexRestApi\Stream\StreamInterface;

/**
 * Interface for a connector that can use streaming output, through a Stream
 *
 * @package RA\SilexRestApi\Connector
 */
interface StreamingConnectorInterface {

    /**
     * Setter for the stream
     *
     * @param StreamInterface $stream
     *
     * @return mixed
     */
    public function setStream(StreamInterface $stream);

} 