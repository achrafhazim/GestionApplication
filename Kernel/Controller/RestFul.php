<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller;

use Kernel\Controller\RestFul\DELETE;
use Kernel\Controller\RestFul\GET;
use Kernel\Controller\RestFul\POST;
use Kernel\Controller\RestFul\PUT;
use Kernel\Tools\Tools;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

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


        $route = $this->getRouter()->match($this->getRequest());
        $this->setRoute($route);
        $namecontrole = $this->getRoute()->getParam("controle");
        $this->setNameController($namecontrole);








        if ($this->is_Erreur("Controller")) {

            return $this->getResponse()
                            ->withStatus(404)
                            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        }

        $method_HTTP = $this->getRequest()->getMethod();

        $data = [];

        if ($method_HTTP === "GET") {

            $api = new GET($this->getContainer(), $this->getModel());
            $GET = $this->getRequest()->getQueryParams();
            $id = (int) $this->getRoute()->getParam("id");
            $data = $api->run($id, $GET);
        }
        if ($method_HTTP === "DELETE") {
            $api = new DELETE($this->getContainer(), $this->getModel());
            $id = (int) $this->getRoute()->getParam("id");
            $code = $api->run($id);
        }
        if ($method_HTTP === "POST") {
            $api = new POST($this->getContainer(), $this->getModel());
            $code = $api->run();
        }
        if ($method_HTTP === "PUT") {
            $api = new PUT($this->getContainer(), $this->getModel());
            $id = (int) $this->getRoute()->getParam("id");
            $code = $api->run($id);
        }
        $json = Tools::json_js($data);
        $this->getResponse()->getBody()->write($json);
        return $this->getResponse()->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

}
