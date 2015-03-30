<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 23.03.15
 * Time: 14:43
 */

namespace RA\SilexRestApi\Connector;


use RA\SilexRestApi\Connector\Oxid\ApplicationConnector;
use RA\SilexRestApi\Filter\FilterInterface;

interface ConnectorInterface {

    public function setApplicationConnector(ApplicationConnectorInterface $appConnector);

    public function getOne($identifier);

    public function getAll(FilterInterface $filter = null);

} 