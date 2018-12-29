<?php

$ROOT = dirname(dirname(__DIR__));
require $ROOT . "/Bootstrap/define.php";


use Kernel\AWA_Interface\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;




$container = $app->getContainer();
$pathModules = $app->getPathModules();


$migrations = array_map(function(string $pathModule): string {
    return $pathModule . "/phinix_db/migrations";
}, $pathModules);

$seeds = array_map(function(string $pathModule): string {
    return $pathModule . "/phinix_db/seeds";
}, $pathModules);

$PDO = $container->get(ModelInterface::class)->getDatabase();
$DBname = $container->get(ModelInterface::class)->getDBnames();
return [
    "paths" => [
        "migrations" => $migrations,
        "seeds" => $seeds
    ]
    , 'environments' =>
    [
        'default_database' => 'development',
        'development' => [
            "name" => $DBname,
            'connection' => $PDO
        ]
    ]
];


