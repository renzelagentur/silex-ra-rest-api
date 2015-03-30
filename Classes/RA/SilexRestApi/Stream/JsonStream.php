<?php

namespace RA\SilexRestApi\Stream;

/**
 * Stream that outputs valid JSON
 *
 * @package RA\SilexRestApi\Stream
 */
class JsonStream implements StreamInterface {

    private $rowCount = 0;

    /**
     * @inheritdoc
     */
    public function start()
    {
        echo "[\n";
        @ob_flush();
        flush();
    }

    /**
     * @inheritdoc
     *
     * @param $row
     */
    public function streamRow($row)
    {
        if ($this->rowCount > 0) {
            echo ',';
        }
        echo json_encode($row);
        echo "\n";
        @ob_flush();
        flush();
        $this->rowCount++;
    }

    /**
     * @inheritdoc
     */
    public function finish()
    {
        echo "]\n";
        @ob_flush();
        flush();
    }
}