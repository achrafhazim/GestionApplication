<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author wassime
 */

namespace Kernel\AWA_Interface;

use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Container\ContainerInterface;

interface ModuleInterface
{

    public function getControllers();

    public function __construct(ContainerInterface $container);

    /**
     * add path view
     * @param RendererInterface $renderer
     * @param string $pathModules
     */
    public function addPathRenderer(RendererInterface $renderer,string $pathModules);

    /**
     * add path url
     * set controller
     * set middlewares to controller
     * @param RouterInterface $router
     */
    public function addRoute(RouterInterface $router);

    /**
     * add item to menu
     */
    public function getMenu(): array;

    /**
     *
     * @param array $middlewares
     */
    public function addMiddlewares($middlewares);
}
