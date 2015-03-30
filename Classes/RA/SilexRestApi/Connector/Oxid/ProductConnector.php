<?php

namespace RA\SilexRestApi\Connector\Oxid;

use RA\SilexRestApi\Connector\ApplicationConnectorInterface;
use RA\SilexRestApi\Connector\ProductConnectorInterface;
use RA\SilexRestApi\Connector\StreamingConnectorInterface;
use RA\SilexRestApi\Filter\Constraint\Equals;
use RA\SilexRestApi\Filter\Constraint\LogicalOr;
use RA\SilexRestApi\Filter\Filter;
use RA\SilexRestApi\Filter\FilterInterface;
use RA\SilexRestApi\Query\DbalQuery;
use RA\SilexRestApi\Stream\StreamInterface;
use Silex\Application;

/**
 * Connector to fetch products from the oxid shop
 *
 * @package RA\SilexRestApi\Connector\Oxid
 */
class ProductConnector implements ProductConnectorInterface, StreamingConnectorInterface {

    /**
     * @var Application
     */
    private $app;

    /**
     * @var StreamInterface
     */
    private $stream;

    /**
     * The view database view
     * @var string
     */
    private $viewName;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * @inheritdoc
     * @param FilterInterface $filter
     */
    public function getOne($identifier)
    {
        $query = new DbalQuery($this->app['db'], $this->viewName);
        $query->setFields(array('*'));

        $filter = new Filter();
        $constraint = new LogicalOr(
            new Equals('OXID', $identifier),
            new Equals('OXARTNUM', $identifier)
        );

        $filter->setRootConstraint($constraint);
        if ($filter !== null) {
            $query->setFilter($filter);
        }

        $stmnt =  $query->generate()->execute();

        return $stmnt->fetch();
    }

    /**
     * @inheritdoc
     * @param FilterInterface $filter
     */
    public function getAll(FilterInterface $filter = null)
    {
        $query = new DbalQuery($this->app['db'], $this->viewName);
        $query->setFields(array('*'));

        if ($filter !== null) {
            $query->setFilter($filter);
        }

        $stmnt =  $query->generate()->execute();
        $rows = array();

        $this->stream->start();
        while ($row = $stmnt->fetch()) {
            $this->stream->streamRow($row);
        }
        $this->stream->finish();

        return $rows;
    }

    public function setStream(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    public function setApplicationConnector(ApplicationConnectorInterface $appConnector)
    {
        if ($appConnector instanceof ApplicationConnector) {
            $this->viewName = getViewName('oxarticles', $appConnector->getLanguage(), $appConnector->getClient());
        }

    }
}