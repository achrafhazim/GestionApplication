<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Middleware;

/**
 * Description of Midd_pse15
 *
 * @author wassime
 */
class midd_pse152 implements \Psr\Http\Server\MiddlewareInterface
{

    public function process(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
    {
        $res = $handler->handle($request);
        $d = (string) $res->getBody();
        $string = "jjjjjj" . $d . "kkkkkkk";
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $string);
        $s = new \GuzzleHttp\Psr7\Stream($stream);

        return $res->withBody($s);
    }
}
