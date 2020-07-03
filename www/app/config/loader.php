<?php

use Phalcon\Loader;

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->pluginsDir,
        $config->application->formsDir,
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
