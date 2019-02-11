<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\RestFul;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of api
 *
 * @author wassime
 */
class api extends RestFul {

    function __construct($container) {


        $this->Options = ["container" => $container,
            "namesControllers" => [],
            "nameModule" => "",
            "middlewares" => [],
            "nameRoute" => ""
        ];
        parent::__construct($this->Options);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);
        
        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        return $this->restfull();
    }

}
