<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 30.03.15
 * Time: 12:17
 */

namespace RA\SilexRestApi\Connector;


use RA\SilexRestApi\Filter\FilterInterface;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ConnectorServiceProvider implements ServiceProviderInterface {

    /**
     * @var string
     */
    private $connectedApp;

    function __construct($connectedApp)
    {
        $this->connectedApp = $connectedApp;
    }


    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $app['filter.defaults.product'] = $app->share(function() use($app) {
                $class = $this->getNamespacedClassName('DefaultProductFilter', $this->connectedApp);
                if (class_exists($class)) {
                    $defaultProductFilter =  new $class($app['request']->get('q', ''));
                    if (isset($defaultProductFilter) && $defaultProductFilter instanceof FilterInterface) {
                        return $defaultProductFilter;
                    }
                }
                return null;

            });

        $app['filter.defaults.category'] = $app->share(function() use($app) {
                $class = $this->getNamespacedClassName('DefaultCategoryFilter', $this->connectedApp);
                if (class_exists($class)) {
                    $defaultProductFilter =  new $class($app['request']->get('q', ''));
                    if (isset($defaultProductFilter) && $defaultProductFilter instanceof FilterInterface) {
                        return $defaultProductFilter;
                    }
                }
                return null;

            });

        $app['connector.applicationConnector'] = $app->share(function() use($app) {
                $class = $this->getNamespacedClassName('ApplicationConnector', $this->connectedApp);
                if (class_exists($class)) {
                    $connector =  new $class($app);
                    if (isset($connector) && $connector instanceof ApplicationConnectorInterface) {
                        $connector->connect($app);
                        return $connector;
                    }
                }
                return null;
            });

        $app['connector.productConnector'] = $app->share(function() use ($app) {
                $class = $this->getNamespacedClassName('ProductConnector', $this->connectedApp);
                if (class_exists($class)) {
                    $connector =  new $class($app);
                    if (isset($connector) && $connector instanceof ProductConnectorInterface) {
                        $connector->setApplicationConnector($app['connector.applicationConnector']);
                        return $connector;
                    }
                }
                return null;
            });

        $app['connector.categoryConnector'] = $app->share(function() use ($app) {
                $class = $this->getNamespacedClassName('CategoryConnector', $this->connectedApp);
                if (class_exists($class)) {
                    $connector =  new $class($app);
                    if (isset($connector) && $connector instanceof CategoryConnectorInterface) {
                        $connector->setApplicationConnector($app['connector.applicationConnector']);
                        return $connector;
                    }
                }
                return null;
            });

    }

    private function getNamespacedClassName($className, $connectedApplication) {
        return sprintf('\\RA\\SilexRestApi\\Connector\\%s\\%s', $connectedApplication, $className);
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
    }
}