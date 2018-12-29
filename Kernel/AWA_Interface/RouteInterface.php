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

use Psr\Http\Server\MiddlewareInterface;

interface RouteInterface
{

    function __construct(MiddlewareInterface $middleware, string $name, array $params, bool $success = true);

    function isSuccess(): bool;

    function getMiddleware(): MiddlewareInterface;

    function getName(): string;

    function getParams(): array;

    function getParam(string $index);

    function setMiddleware(MiddlewareInterface $middleware);

    function setName(string $name);

    function setParams(array $params);
}
