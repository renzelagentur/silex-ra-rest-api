<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 24.03.15
 * Time: 10:55
 */

namespace RA\SilexRestApi\Connector;

use Silex\Application;

/**
 * Interface that describes a service, that executes generic tasks to connect to a given application, before
 * the actually fetching of data is done
 *
 * @package RA\SilexRestApi\Connector
 */
interface ApplicationConnectorInterface {

    /**
     * Method that is called to connect to the application
     * @return mixed
     */
    public function connect(Application $app);

}
