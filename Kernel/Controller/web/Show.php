<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\web;

/**
 * Description of show
 *
 * @author wassim
 */
class Show {
 
    private $model;

    function __construct($model) {
        $this->model = $model;
    }

    public function run($id) {
          return $this->model->show_styleForm($id);
        
       
    }
}
