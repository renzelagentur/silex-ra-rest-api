<?php

use RA\SilexRestApi\Connector\ConnectorServiceProvider;
use RA\SilexRestApi\Connector\DataConnectorFactory;
use RA\SilexRestApi\Controller\CategoryController;
use RA\SilexRestApi\Controller\ProductController;
use RA\SilexRestApi\Filter\Builder\RequestFilterBuilder;
use RA\SilexRestApi\Provider\CategoryControllerProvider;
use RA\SilexRestApi\Provider\ProductControllerProvider;
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();
// register to use controller as service
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app['debug'] = defined('DEBUG_MODE') && DEBUG_MODE === TRUE;

// Convert JSON Body requests into actual objects
$app->before(function (Request $request) {
    if (0 === strpos(strtolower($request->headers->get('Content-Type')), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

//////////////////////////////////////////////////////////////////////////
// SERVICE DEFINITION START                                            //
//////////////////////////////////////////////////////////////////////////
$app['filter.builder.request'] = $app->share(function() use($app) {
       return new RequestFilterBuilder($app['request']);
    });

$app->register(new ConnectorServiceProvider(CONNECTED_APP));

$app['controller.productController'] = $app->share(function() use ($app) {
    return new ProductController($app['connector.productConnector'], $app['filter.builder.request']);
});

$app['controller.categoryController'] = $app->share(function() use ($app) {
        return new CategoryController($app['connector.categoryConnector'], $app['filter.builder.request']);
    });


//////////////////////////////////////////////////////////////////////////
// SERVICE DEFINITION END                                              //
//////////////////////////////////////////////////////////////////////////

// Workarround for Oxid's autoloader throwing warnings
ini_set('display_errors', 'off');
if (function_exists('xdebug_disable')) {
    xdebug_disable();
}

$app->mount('/products', new ProductControllerProvider());
$app->mount('/categories', new CategoryControllerProvider());
$app->run();
