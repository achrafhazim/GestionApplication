<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function substr;

/**
 * Description of TrailingSlash
 *
 * @author wassime
 */
class TrailingSlash implements MiddlewareInterface
{
    private $container;
    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $url = $request->getUri()->getPath();
        
        /**
         * exemple http://awa.ma/CRM/hh/ ===> http://awa.ma/CRM/hh
         */
        $response = $this->container->get(ResponseInterface::class);
        if (!empty($url) && $url != "/" && $url[-1] === "/") {
            $urTrailing = substr($url, 0, -1);
            return $response
                    ->withHeader("Location", $urTrailing)
                    ->withStatus(301);
        }
        return $handler->handle($request);
    }
}
