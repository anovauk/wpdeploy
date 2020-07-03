<?php

use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Loader as Loader;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Crypt;

// Using the CLI factory default services container
$di = new CliDI();

// Load the configuration file (if any)
$configFile = __DIR__ . '/config/config.php';

if (is_readable($configFile)) {
    $config = include $configFile;
    
    $di->set('config', $config);
}

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
            ]
            );
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

/**
 * Register the autoloader and tell it to register the tasks directory
 */
$loader = new Loader();

$loader->registerDirs(
    [
        __DIR__ . '/tasks',
        __DIR__ . '/models',
    ]
    );

// Register files
$loader->registerFiles(
    [
        $config->application->baseDir . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php',
        $config->application->baseDir . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'autoload.php',
    ]
);

$loader->register();

// Create a console application
$console = new ConsoleApp();

$console->setDI($di);

/**
 * Process the console arguments
 */
$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments['task'] = $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Do Phalcon related stuff here
    // ..
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
}
