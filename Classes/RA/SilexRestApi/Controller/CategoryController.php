<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 23.03.15
 * Time: 12:46
 */

namespace RA\SilexRestApi\Controller;


use RA\SilexRestApi\Connector\CategoryConnectorInterface;
use RA\SilexRestApi\Filter\Builder\BuilderInterface;
use RA\SilexRestApi\Stream\JsonStream;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController {

    /**
     * @var CategoryConnectorInterface
     */
    private $categoryConnector;

    /**
     * @var BuilderInterface
     */
    private $filterBuilder;

    /**
     * @param CategoryConnectorInterface $categoryConnector
     * @param BuilderInterface          $filterBuilder
     */
    public function __construct(CategoryConnectorInterface $categoryConnector, BuilderInterface $filterBuilder) {
        $this->categoryConnector = $categoryConnector;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * Used to retriebe a single category
     *
     * @param Application $app
     * @param             $categoryIdentifier
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getCategoryAction(Application $app, $categoryIdentifier) {
        $result = $this->categoryConnector->getOne($categoryIdentifier);
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
    public function getCategoriesAction(Application $app) {
        $filter = $this->filterBuilder->build();
        if ($filter === NULL &&  $app['filter.defaults.category'] !== NULL) {
            $filter = $app['filter.defaults.category'];
        }

        if ($this->categoryConnector instanceof \RA\SilexRestApi\Connector\StreamingConnectorInterface) {
            $stream = new JsonStream();
            $this->categoryConnector->setStream($stream);
            return $app->stream(function() use ($filter) {$this->categoryConnector->getAll($filter); }, 200, array('Content-Type' => 'application/json'));
        }
        return $app->json($this->categoryConnector->getAll($filter));
    }

} 