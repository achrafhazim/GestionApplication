<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\RestFul;

use Kernel\AWA_Interface\Base_Donnee\MODE_SELECT_Interface;
use Kernel\Tools\Tools;
use function array_merge;

/**
 * Description of PUTcontroller
 *
 * @author wassime
 */
class PUT {

    private $Container;
    private $model;

    function __construct($Container, $model) {
        $this->Container = $Container;
        $this->model = $model;
    }

    public function run(int $id,array $POST, array $IconShowFiles) {

        /**
         * merge data post and id files generate save
         */
        $ID=["id"=>$id];
        $insert = array_merge($POST,$ID, $IconShowFiles);


        /**
         * set data to database
         */
        $id_save = $this->model->update($insert);

        $entity = $this->model->find(["id" => $id_save], MODE_SELECT_Interface::MODE_SELECT_ALL_ALL);
        $data = Tools::entitys_TO_array($entity);
        return $data;
    }

}
