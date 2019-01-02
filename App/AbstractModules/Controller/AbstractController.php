<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author wassime
 */

namespace App\AbstractModules\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


use Kernel\Controller\Controller;

abstract class AbstractController extends Controller {
    //actionnnnnnnnnnnnn
     public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        // si is error 
        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        
        // set route 
        $this->setRoute($this->getRouter()->match($this->getRequest()));

        // set controller 
        $this->setNameController($this->getRoute()->getParam("controle"));

        // si is error 
        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }
     
        ///////////////////////////////////
        // is ok etap 1
        // get action
        $action = $this->getRoute()->getParam("action");
        // get params
        $params = $this->getRoute()->getParam("params");
        // set actont
        $this->Actions()->setAction($action);
        //http://localhost/CRM/contacts/mm-00
        var_dump($action,$params);        die();
        
       



        return $this->run($id);
    }

    

}
