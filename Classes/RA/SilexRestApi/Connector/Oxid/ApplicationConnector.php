<?php
/**
 * Created by PhpStorm.
 * User: chl
 * Date: 24.03.15
 * Time: 11:10
 */

namespace RA\SilexRestApi\Connector\Oxid;


use RA\SilexRestApi\Connector\ApplicationConnectorInterface;
use Silex\Application;

class ApplicationConnector implements ApplicationConnectorInterface {

    /**
     * @var int The client ID currently used
     */
    private $client;

    /**
     * @var int The language ID currently used
     */
    private $language;

    /**
     * Method that is called to connect to the application
     *
     * @return mixed
     */
    public function connect(Application $app)
    {
        // load oxid bootstrap to load oxid framework
        if (file_exists(CONNECTED_APP_ROOT . 'bootstrap.php')) {
            @include CONNECTED_APP_ROOT . 'bootstrap.php';
        } else {
            throw new \RuntimeException('Cannot load Oxid config, without knowing where the oxid root is. Plase make sure that CONNECTED_APP_ROOT is defined');
        }

        $app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
                'db.options' => array(
                    'driver'    => 'pdo_mysql',
                    'host'      => \oxRegistry::getConfig()->getConfigParam('dbHost'),
                    'dbname'    => \oxRegistry::getConfig()->getConfigParam('dbName'),
                    'user'      => \oxRegistry::getConfig()->getConfigParam('dbUser'),
                    'password'  => \oxRegistry::getConfig()->getConfigParam('dbPwd'),
                    'charset'   => 'utf8'
                )
            ));

        $this->setClient($app['request']->get('client', 0));
        $this->setLanguage($app['request']->get('language', 0));
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }


}