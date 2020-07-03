<?php

use Phalcon\Mvc\Application;

// Set the Locale
setlocale(LC_MONETARY, 'en_AU');

try {

    /*
     * Read the configuration
     */
    $config = include __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";

    /**
     * Read auto-loader
     */
    include __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "loader.php";

    /**
     * Read services
     */
    include __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "services.php";

    /*
     *  Handle the request
     */
    $application = new Application($di);
    $response    = $application->handle();
    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
