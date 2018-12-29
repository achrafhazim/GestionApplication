<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of Despatcher
 *
 * @author wassime
 */
class Despatcher implements RequestHandlerInterface
{

    private $middlwares = [];
    private $protoTypeRespons;

    /*
     * Return middlwares|| null
     */

    function getMiddlwares()
    {
        return array_shift($this->middlwares);
    }

    function __construct(ResponseInterface $prototypeRespons)
    {
        $this->protoTypeRespons = $prototypeRespons;
    }

    public function pipe(MiddlewareInterface $middleware)
    {
        $this->middlwares[] = $middleware;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
       // var_dump($this->middlwares);die();
        
        $middlware = $this->getMiddlwares();
       
        if ($middlware != null) {
            return $middlware->process($request, $this);
        } else {
            return $this->protoTypeRespons;
        }
    }
}
