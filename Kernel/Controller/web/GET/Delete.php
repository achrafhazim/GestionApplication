<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\web\GET;

use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\Event\Event;
use Kernel\INTENT\Intent_Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Kernel\Controller\WebController;
use function substr;

/**
 * Description of delete
 *
 * @author wassim
 */
class Delete {

    private $model;

    function __construct($model) {
        $this->model = $model;
    }

    public function run($id) {

        $conditon = ['id' => $id];



        $etat = $this->model->delete($conditon);
    }

}
