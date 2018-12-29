<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of DefaultController
 *
 * @author wassime
 */
class DefaultController implements MiddlewareInterface{
    //put your code here
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        
    }

}
