<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Kernel\Tools\Tools;

/**
 * Description of RestFul
 *
 * @author wassime
 */
class RestFul extends Controller {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        $this->setRoute($this->getRouter()->match($this->getRequest()));
        $this->setNameController($this->getRoute()->getParam("controle"));
        $method_HTTP = $this->getRequest()->getMethod();







        if ($this->is_Erreur("Controller")) {

            return $this->getResponse()
                            ->withStatus(404)
                            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        }



        if ($method_HTTP === "GET") {

            $api = new RestFul\GET($this->getContainer(), $this->getModel());
            $GET = $this->getRequest()->getQueryParams();
            $id = (int) $this->getRoute()->getParam("id");
            $data = $api->run($id, $GET);
            $json = Tools::json_js($data);
            $this->getResponse()->getBody()->write($json);
            return $this->getResponse()->withHeader('Content-Type', 'application/json; charset=utf-8');
        }
        if ($method_HTTP === "DELETE") {
            $api = new RestFul\DELETE($this->getContainer(), $this->getModel());
            $id = (int) $this->getRoute()->getParam("id");
            $code = $api->run($id);
            die($code);
        }
        if ($method_HTTP === "POST") {
            $api = new RestFul\POST($this->getContainer(), $this->getModel());
            $code = $api->run();
            die($code);
        }
        if ($method_HTTP === "PUT") {
            $api = new RestFul\PUT($this->getContainer(), $this->getModel());
            $id = (int) $this->getRoute()->getParam("id");
            $code = $api->run($id);
            die($code);
        }
    }

}
