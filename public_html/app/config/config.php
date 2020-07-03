<?php

$config = new \Phalcon\Config(
    [
        "application" => [
            "name"           => 'WPDeployment',
            "baseUri"        => "/",
            "baseUrl"        => "https://ipstech.app/",
            "baseDir"        => dirname(dirname(__DIR__) . "../"),
            "controllersDir" => dirname(__DIR__) . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR,
            "modelsDir"      => dirname(__DIR__) . DIRECTORY_SEPARATOR . "models" . DIRECTORY_SEPARATOR,
            "viewsDir"       => dirname(__DIR__) . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR,
            "pluginsDir"     => dirname(__DIR__) . DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR,
            "formsDir"       => dirname(__DIR__) . DIRECTORY_SEPARATOR . "forms" . DIRECTORY_SEPARATOR,
            "pdfDir"         => dirname(dirname(__DIR__) . "../") . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "tmp" . DIRECTORY_SEPARATOR,
        ],
        "cache" => [
            "cacheLifetime"     => 3600, // Lifetime of 1 hour expressed as seconds
            "cacheDir"          => dirname(dirname(__DIR__) . "../") . DIRECTORY_SEPARATOR . "cache" . DIRECTORY_SEPARATOR,
        ],
        "volt"        => [
            "compiledPath"      => dirname(dirname(__DIR__) . "../") . DIRECTORY_SEPARATOR . "var" . DIRECTORY_SEPARATOR . "compiled-templates" . DIRECTORY_SEPARATOR,
            "compiledExtension" => ".compiled",
        ],
        "db" => [
            "host" => "localhost",
            "username" => "ipstech_db",
            "password" => ".QZAJF_h;,g}",
            "dbname" => "ipstech_db",
        ],
        "encryption" => [
            "key" => 'S+:b:^_cVWarV:Q-4zy!%D[65:&h@dHY',
        ]
    ]
);

return $config;
