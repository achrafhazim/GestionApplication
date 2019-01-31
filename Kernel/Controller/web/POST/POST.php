<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\web\POST;

use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\AWA_Interface\PasswordInterface;
use Kernel\Event\Event;
use function array_merge;
use function preg_match;
use function str_replace;

/**
 * Description of POST
 *
 * @author wassim
 */
class POST {

    private $model;
    private $Container;
    private $Child;
    private $NameController;
    private $file_Upload;
    private $RequestUploadedFiles;
    private $RequestPOST;
    private $Router;
    private $Actions;
            function __construct($Container, $model, $Child, $NameController, $file_Upload, $RequestUploadedFiles, $RequestPOST,$Router,$Actions) {
        $this->Child = $Child;
        $this->file_Upload = $file_Upload;
        $this->NameController = $NameController;
        $this->RequestUploadedFiles = $RequestUploadedFiles;
        $this->model = $model;
        $this->Container = $Container;
        $this->RequestPOST = $RequestPOST;
        $this->Router = $Router;
         $this->Actions = $Actions;
    }

  
    public function run( string $routeFile = "") {
        if ($this->Child !== false) {
            return $this->send_data_ParantChild($routeFile);
        } else {
            return $this->send_data_normal($routeFile);
        }
    }

    protected function send_data_normal( string $routeFile = "") {


        /**
         * save les files
         * get id files save
         */
        $file_Upload = $this->file_Upload;
        $file_Upload->setPreffix($this->NameController);
        $uploadedFiles = $this->RequestUploadedFiles;
        $keyFilesSave = $file_Upload->save($uploadedFiles);

        /**
         * generate Uri Files save
         * pour view
         */
        $IconShowFiles = $this->generateIconShow($routeFile, $keyFilesSave);

//        /**
//         * get data post
//         *
//         */
//        $POST = $this->getRequest()->getParsedBody();
        /**
         * ecypte password
         */
        $POST = $this->encryptPassword($this->RequestPOST);
        /**
         * update
         * remove file has is
         */
        $this->deleteFile($POST, $IconShowFiles);
        /**
         * merge data post and id files generate save
         */
        $insert = array_merge($POST, $IconShowFiles);


        /**
         * set data to database
         */
        $id_parent = $this->model->setData($insert);

        /**
         * get data save to model
         */
        $intent = $this->model->show_styleForm($id_parent);
        return ["intent" => $intent];
        /**
         * show data get par model
         */
        return $this->render($view_show, ["intent" => $intent]);
    }

    protected function send_data_ParantChild( string $routeFile = "") {

        //$request = $this->getRequest();
        // get data insert merge par parent et child
        $insertcler = $this->RequestPOST;
        /**
         * ecypte password
         */
        $insert = $this->encryptPassword($insertcler);

        // parse data
        $parseData = $this->parseDataPerant_child($insert);
        $data_parent = $parseData["data_parent"];
        $data_child = $parseData["data_child"];


        //  save data parent
        $table_parent = $this->NameController;
        $this->model->setTable($table_parent);

        // insert data
        // $id_parent pour gere relation et data lier(exemple raison social)
        $id_parent = $this->model->setData($data_parent);

        /*         * ************************* */
        //  save relation
        /// save image

        $file_Upload = $this->file_Upload;
        $file_Upload->setPreffix($this->NameController);
        $uploadedFiles = $this->RequestUploadedFiles;
        /**
         * keyFilesSaves
         * $index int ==> row qui is file save
         * value => keyFilesSave array
         *   name input file and data inpute
         */
        $keyFilesSaves = $file_Upload->save_child($uploadedFiles);
        $IconShowFiles = $this->generateIconShow($routeFile, $keyFilesSaves, false);

        /// childe achats => achat
        //$Controller_child = substr( $this->NameController, 0, -1);
        $Controller_child = $this->Child;
        /// save data child
       $this->model->setTable($Controller_child);

        /**
         *  merge data post and id files generate save
         */
        foreach ($IconShowFiles as $index => $IconShowFile) {
            foreach ($IconShowFile as $nameinput => $IconShow) {
                $data_child[$index][$nameinput] = $IconShow;
            }
        }
        $this->model->setData($data_child, $table_parent, $id_parent);


        /// show etem save
        $this->model->setTable($this->NameController);

        $intent = $this->model->show_styleForm($id_parent);
         return ["intent" => $intent];

       
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
                $url = $this->Router->generateUri($nameRoute, ["controle" => $this->NameController, "action" => $this->Actions->name_files(), "id" => $filesuploade["id_files"]]);
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
     * delete file par event
     * @param array $insert
     * @param array $IconShowFiles
     */
    private function deleteFile(array $insert, array $IconShowFiles) {

        if (isset($insert['id']) && $insert['id'] != "" && !empty($IconShowFiles)) {
            $eventManager = $this->Container->get(EventManagerInterface::class);

            $event = new Event();
            $event->setName("delete_files");
            $event->setParams(["url_id_file" => $this->model->get_idfile($insert['id'])]);
            $eventManager->trigger($event);
        }
    }

    /**
     * ecypt password
     */
    protected function encryptPassword(array $dataForm): array {
        if (isset($dataForm["password"])) {
            $password = $this->Container->get(PasswordInterface::class);
            $hash = $password->encrypt($dataForm["password"]);

            $dataForm["password"] = $hash;
        }



        return$dataForm;
    }

}
