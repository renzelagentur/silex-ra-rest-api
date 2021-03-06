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
 * Provider Class, that defines the routes for the Category Controller
 *
 * @package RA\SilexRestApi\Provider
 */
class CategoryControllerProvider implements ControllerProviderInterface {

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
        $factory->get('/', "controller.categoryController:getCategoriesAction");
        $factory->get('/search', "controller.categoryController:getCategoriesAction");
        $factory->post('/search', "controller.categoryController:getCategoriesAction");

        $factory->get('/{categoryIdentifier}', "controller.categoryController:getCategoryAction");

        return $factory;
    }
}