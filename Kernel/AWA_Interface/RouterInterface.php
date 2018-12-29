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

use Kernel\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

interface RouterInterface extends MiddlewareInterface
{

  

    public function addRoute(string $url, MiddlewareInterface $middleware, $methods = null, string $name, string $nameModule = "");

    public function addRoute_get(string $url, MiddlewareInterface $middleware, string $name, string $nameModule = "") ;

    public function addRoute_post(string $url, MiddlewareInterface $middleware, string $name, string $nameModule = "") ;

    public function addRoute_put(string $url, MiddlewareInterface $middleware, string $name, string $nameModule = "") ;

    public function addRoute_patch(string $url, MiddlewareInterface $middleware, string $name, string $nameModule = "");

    public function addRoute_delete(string $url, MiddlewareInterface $middleware, string $name, string $nameModule = "") ;

    public function addRoute_any(string $url, MiddlewareInterface $middleware, string $name, string $nameModule = "") ;

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    public function generateUri($name, array $substitutions = [], array $options = []): string ;

    public function match(ServerRequestInterface $request): RouteInterface;
}
