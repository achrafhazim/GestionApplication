<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\RestFul;

use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\AWA_Interface\PasswordInterface;
use Kernel\Event\Event;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function array_merge;
use function preg_match;
use function str_replace;

/**
 * Description of POSTcontroller
 *
 * @author wassime
 */
class POST  {

    private $Container;
    private $model;

    function __construct($Container, $model) {
        $this->Container = $Container;
        $this->model = $model;
    }
 

    public function send_data(string $routeFile = ""): ResponseInterface {
        if ($this->getChild() !== false) {
            return $this->send_data_ParantChild($routeFile);
        } else {
            return $this->send_data_normal($routeFile);
        }
    }

    protected function send_data_normal(string $routeFile = ""): ResponseInterface {
       

        $IconShowFiles = $this->save_files($routeFile);
        $POST = $this->data_HTTP();

        /**
         * merge data post and id files generate save
         */
        $insert = array_merge($POST, $IconShowFiles);


        /**
         * set data to database
         */
        $id_parent = $this->getModel()->setData($insert);
        echo $id_parent;
        die($id_parent);
    }

    protected function send_data_ParantChild(string $view_show, string $routeFile = ""): ResponseInterface {
        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }
        $request = $this->getRequest();



        // get data insert merge par parent et child
        $insertcler = $request->getParsedBody();
        /**
         * ecypte password
         */
        $insert = $this->encryptPassword($insertcler);

        // parse data
        $parseData = $this->parseDataPerant_child($insert);
        $data_parent = $parseData["data_parent"];
        $data_child = $parseData["data_child"];


        //  save data parent
        $table_parent = $this->getNameController();
        $this->chargeModel($table_parent);

        // insert data
        // $id_parent pour gere relation et data lier(exemple raison social)
        $id_parent = $this->getModel()->setData($data_parent);

        /*         * ************************* */
        //  save relation
        /// save image

        $file_Upload = $this->getFile_Upload();
        $file_Upload->setPreffix($this->getNameController());
        $uploadedFiles = $this->getRequest()->getUploadedFiles();
        /**
         * keyFilesSaves
         * $index int ==> row qui is file save
         * value => keyFilesSave array
         *   name input file and data inpute
         */
        $keyFilesSaves = $file_Upload->save_child($uploadedFiles);
        $IconShowFiles = $this->generateIconShow($routeFile, $keyFilesSaves, false);

        /// childe achats => achat
        //$Controller_child = substr($this->getNameController(), 0, -1);
        $Controller_child = $this->getChild();
        /// save data child
        $this->chargeModel($Controller_child);

        /**
         *  merge data post and id files generate save
         */
        foreach ($IconShowFiles as $index => $IconShowFile) {
            foreach ($IconShowFile as $nameinput => $IconShow) {
                $data_child[$index][$nameinput] = $IconShow;
            }
        }
        $this->getModel()->setData($data_child, $table_parent, $id_parent);


        echo $id_parent;
        die($id_parent);
    }

    ////////////////////////////////////////////////////////////////////
    private function save_files($routeFile): array {
        /**
         * save les files
         * get id files save
         */
        $file_Upload = $this->getFile_Upload();
        $file_Upload->setPreffix($this->getNameController());
        $uploadedFiles = $this->getRequest()->getUploadedFiles();
        $keyFilesSave = $file_Upload->save($uploadedFiles);

        /**
         * generate Uri Files save
         * pour view
         */
        $IconShowFiles = $this->generateIconShow($routeFile, $keyFilesSave);
        return $IconShowFiles;
    }

    private function data_HTTP(): array {
        /**
         * get data post
         *
         */
        $POST = $this->getRequest()->getParsedBody();
        /**
         * ecypte password
         */
        $POSTencrypt = $this->encryptPassword($POST);
        return $POSTencrypt;
    }

    ///////////////////////////////////////////////////////////////////

    private function parseDataPerant_child(array $data_set): array {

        $data_parent = [];
        $data_child = [];

        // parse data => dataperant and datachild
        foreach ($data_set as $key => $data) {
            if (preg_match("/\_child\b/i", $key)) {
                $data_child[str_replace("_child", "", $key)] = $data;
            } else {
                $data_parent[$key] = $data;
            }
        }


        // sort array data child

        $data_child_sort = [];
        foreach ($data_child as $i => $element) {
            foreach ($element as $j => $sub_element) {
                $data_child_sort[$j][$i] = $sub_element;
            }
        }

        return [
            "data_parent" => $data_parent,
            "data_child" => $data_child_sort
        ];
    }

    private function generateIconShow(string $nameRoute, array $keyFilesSave, bool $default = true): array {

        if ($default) {
            /**
             * insert data simple par form
             */
            $IconShowFile = [];
            foreach ($keyFilesSave as $nameInput => $filesuploade) {
                $url = $this->getRouter()->generateUri($nameRoute, ["controle" => $filesuploade["id_files"]]);
                /*
                 * icon <a hre base par twitre bootstrap
                 */
                $IconShowFile[$nameInput] = '<a class="btn "  role="button"'
                        . ' href="' . $url . '" '
                        . ' data-regex="/' . $filesuploade["id_files"] . '/" > '
                        . '<spam class="glyphicon glyphicon-download-alt"></spam> '
                        . $filesuploade["count_files"] .
                        '</a>';
            }
            return $IconShowFile;
        } else {
            /*
             * insert data par form child
             * plus row
             */

            $IconShowFiles = [];

            foreach ($keyFilesSave as $key => $keyFileSave) {
                $IconShowFiles [$key] = $this->generateIconShow($nameRoute, $keyFileSave);
            }
            return $IconShowFiles;
        }
    }

    /**
     * ecypt password
     */
    protected function encryptPassword(array $dataForm): array {
        if (isset($dataForm["password"])) {
            $password = $this->getContainer()->get(PasswordInterface::class);
            $hash = $password->encrypt($dataForm["password"]);

            $dataForm["password"] = $hash;
        }



        return$dataForm;
    }

}
