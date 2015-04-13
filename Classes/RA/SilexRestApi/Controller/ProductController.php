<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 23.03.15
 * Time: 12:46
 */

namespace RA\SilexRestApi\Controller;


use RA\SilexRestApi\Connector\ProductConnectorInterface;
use RA\SilexRestApi\Filter\Builder\BuilderInterface;
use RA\SilexRestApi\Stream\JsonStream;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController {

    /**
     * @var CategoryConnectorInterface
     */
    private $productConnector;

    /**
     * @var BuilderInterface
     */
    private $filterBuilder;

    /**
     * @param ProductConnectorInterface $productConnector
     * @param BuilderInterface          $filterBuilder
     */
    public function __construct(ProductConnectorInterface $productConnector, BuilderInterface $filterBuilder) {
        $this->productConnector = $productConnector;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * Used to retriebe a single product
     *
     * @param Application $app
     * @param             $productIdentifier
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getProductAction(Application $app, $productIdentifier) {
        $result = $this->productConnector->getOne($productIdentifier);
        if ($result) {
            return $app->json($result);
        } else {
            return new Response("Not found", 404);
        }
    }

    /**
     * Action that renders all products
     *
     * @param Application $app
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getProductsAction(Application $app) {
        if ($app['filter.defaults.product'] !== NULL) {
            $filter = $this->filterBuilder->build($app['filter.defaults.product']);
        } else {
            $filter = $this->filterBuilder->build();
        }

        if ($this->productConnector instanceof \RA\SilexRestApi\Connector\StreamingConnectorInterface) {
            $stream = new JsonStream();
            $this->productConnector->setStream($stream);
            return $app->stream(function() use ($filter) {$this->productConnector->getAll($filter); }, 200, array('Content-Type' => 'application/json'));
        }
        return $app->json($this->productConnector->getAll($filter));
    }

} 