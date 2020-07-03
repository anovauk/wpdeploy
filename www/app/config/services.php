<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Filter;
use Phalcon\Http\Request;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Cache\Backend\File as BackFile;  
use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Crypt;

// Enable logging to sentry
Sentry\init(['dsn' => 'https://229b5fbcedb645a29d8f2c82ebe29cc8@sentry.io/1850305' ]);

// Create a DI
$di = new FactoryDefault();

// Set config in DI
$di->set(
    "config",
    function () use ($config) {
        return $config;
    }
);

// Set database service
$di->set(
    'db',
    function () use ($config) {
        return new DbAdapter(
            [
                'host'      => $config->db->host,
                'username'  => $config->db->username,
                'password'  => $config->db->password,
                'dbname'    => $config->db->dbname,
                'charset'   => 'utf8'
            ]
        );
    }
);

$di->set(
    'cache',
    function () use ($config) {
        $frontCache = new FrontData(
            [
                'lifetime' => $config->cache->cacheLifetime,
            ]
        );

        $cache = new BackFile(
            $frontCache,
            [
                'cacheDir' => $config->cache->cacheDir,
            ]
        );
        return $cache;
    }
);

$di->set(
    'dispatcher',
    function () {
        // Create an events manager
        $eventsManager = new EventsManager();

        // Listen for events produced in the dispatcher using the Security plugin
        $eventsManager->attach(
            'dispatch:beforeExecuteRoute',
            new SecurityPlugin()
        );

        // Handle exceptions and not-found exceptions using NotFoundPlugin
        $eventsManager->attach(
            'dispatch:beforeException',
            new NotFoundPlugin()
        );

        $dispatcher = new Dispatcher();

        // Assign the events manager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);

// Register Volt as a service
$di->set(
    "voltService",
    function ($view, $di) use ($config) {
        // Instantiate volt
        $volt = new Volt($view, $di);
        // Set volt options
        $volt->setOptions(
            [
                "compiledPath"      => $config->volt->compiledPath,
                "compiledExtension" => $config->volt->compiledExtension,
            ]
        );

        // Return volt
        return $volt;
    }
);

// Setup the view component
$di->set('view', function () use ($config) {
  $view = new View();
  $view->setViewsDir($config->application->viewsDir);
  $view->registerEngines(array(
      '.volt' => function ($view, $di) use ($config) {
          $volt = new Volt($view, $di);
          $volt->setOptions(array(
              'compiledPath' => __DIR__.'/../../cache/',
              'compiledSeparator' => '_',
              'compileAlways' => true,
          ));
          $compiler = $volt->getCompiler();
          $compiler->addFunction('money_format', function ($resolvedArgs, $exprArgs) use ($compiler) {
              $firstArgument = $compiler->expression($exprArgs[0]['expr']);
              return 'money_format(\'%.2n\', '.$firstArgument.')';
          });
          return $volt;
      }
  ));
  return $view;
}, true);

// Setup a base URI
$di->set(
    'url',
    function () use ($config) {
        $url = new UrlProvider();
        $url->setBaseUri($config->application->baseUri);
        return $url;
    }
);

$di->set(
    'filter',
    function () {
        
        // Instantiate new filter
        $filter = new Filter();

        // Add custom filters
        $filter->add('ipv4', function($value) {
            return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        });

        // Return the filter
        return $filter;
    }
);

$di->set(
    'request',
    function () {
        return new Request();
    }
);

$di->setShared(
    'session',
    function () {
        $session = new Session();
        $session->start();
        return $session;
    }
);

// Set up the flash session service
$di->set(
    'flashSession',
    function () {
        $flash = new FlashSession(
            [
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning', 
            ]);
        return $flash;
    }
);

$di->set(
    'crypt',
    function () use ($config) {

        $crypt = new Crypt();

        // Set encryption cipher
        $crypt->setCipher('aes-256-ctr');

        // Set a global encryption key
        $crypt->setKey($config->encryption->key);

        return $crypt;
    },
    true
);

