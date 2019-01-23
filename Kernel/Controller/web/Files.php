<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\web;
use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\Event\Event;
use Kernel\INTENT\Intent_Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Kernel\Controller\WebController;
use function substr;

/**
 * Description of files
 *
 * @author wassim
 */
class Files {
    public function run( $controller,  $id,$view) {}
      protected function files($id, string $view) {
        //clients_2019-01-23-15-14-10
        $find = $this->getNameController() . "_" . $id;
        $files = $this->getFile_Upload()->get($find);

        return $this->render($view, ["files" => $files]);
    }
}
