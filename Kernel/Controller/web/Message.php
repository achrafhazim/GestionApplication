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
 * Description of message
 *
 * @author wassim
 */
class Message {
    private $model;
    private $controller;
    function __construct($model, $controller) {
        $this->model = $model;
        $this->controller = $controller;
    }

    public function run( $rangeID) {

        $mode = $this->model::MODE_SELECT_DEFAULT_NULL;

        return $this->model->show_in($mode, $rangeID);

        
    }
}
