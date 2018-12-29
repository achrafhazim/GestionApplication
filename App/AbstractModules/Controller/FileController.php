<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of FileController
 *
 * @author wassime
 */
 class FileController extends AbstractController
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        parent::process($request, $handler);

        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        $this->setRoute($this->getRouter()->match($this->getRequest()));
        $this->setNameController($this->getRoute()->getParam("controle"));
      


        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }
        return $this->get_views_files("show_files");
     
    }

    public function get_views_files(string $name_views): ResponseInterface
    {
        if ($this->is_Erreur("Controller")) {
            return $this->getResponse()->withStatus(404);
        }
        $files = $this->getFile_Upload()->get($this->getRoute()->getParam("controle"));

        return $this->render($name_views, ["files" => $files]);
    }
}
