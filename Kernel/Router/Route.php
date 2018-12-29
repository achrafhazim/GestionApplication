<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Router;

use Kernel\AWA_Interface\RouteInterface;
use Psr\Http\Server\MiddlewareInterface;

/**
 * Description of Route
 *
 * @author wassime
 */
class Route implements RouteInterface
{

    private $success;
    private $middleware;
    private $name;
    private $params;

    function __construct(MiddlewareInterface $middleware, string $name, array $params, bool $success = true)
    {
        $this->middleware = $middleware;
        $this->name = $name;
        $this->params = $params;
        $this->success = $success;
    }

    function isSuccess(): bool
    {
        return $this->success;
    }

    function getMiddleware(): MiddlewareInterface
    {
        return $this->middleware;
    }

    function getName(): string
    {
        return $this->name;
    }

    function getParams(): array
    {
        return $this->params;
    }

    function getParam(string $index)
    {
        if (isset($this->params[$index])) {
            return $this->params[$index];
        }
    }

    function setMiddleware(MiddlewareInterface $middleware)
    {
        $this->middleware = $middleware;
    }

    function setName(string $name)
    {
        $this->name = $name;
    }

    function setParams(array $params)
    {
        $this->params = $params;
    }
}
