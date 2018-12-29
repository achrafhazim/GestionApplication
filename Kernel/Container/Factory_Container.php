<?php

namespace Kernel\Container;

use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

class Factory_Container
{

    private static $DI = null;

    public static function getContainer(string $pathconfig = "", string $implementscontainer = "local"): ContainerInterface
    {
        if (self::$DI != null) {
            return self::$DI;
        }
        if (!is_file($pathconfig)) {
            throw new TypeError(" erreur path file config ==> $pathconfig  ");
        }
        if ($implementscontainer == "DI") {
            $builder = new ContainerBuilder();
            $builder->addDefinitions($pathconfig);
            $container = $builder->build();
            self::$DI = $container;
            return $container;
        } else {
            $container = DIC::buildContainer();
            $container->addDefinitions($pathconfig);
            self::$DI = $container;
            return $container;
        }
    }
}
