<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 23.03.15
 * Time: 12:56
 */

namespace RA\SilexRestApi\Provider;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

/**
 * Provider Class, that defines the routes for the Product Controller
 *
 * @package RA\SilexRestApi\Provider
 */
class ProductControllerProvider implements ControllerProviderInterface {

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        /**
         * @var \Silex\ControllerCollection $factory
         */
        $factory = $app['controllers_factory'];
        $factory->get('/', "controller.productController:getProductsAction");
        $factory->get('/search', "controller.productController:getProductsAction");
        $factory->post('/search', "controller.productController:getProductsAction");

        $factory->get('/{productIdentifier}', "controller.productController:getProductAction");

        return $factory;
    }
}