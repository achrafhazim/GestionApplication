<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\RestFul;

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
class RestFul extends \Kernel\Controller\Controller {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }




        if ($this->is_Erreur("Controller")) {

            return $this->getResponse()
                            ->withStatus(404)
                            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        }

        return $this->restfull();
    }

    public function restfull() {
        $method_HTTP = $this->getRequest()->getMethod();
        $data = [];

        switch ($method_HTTP) {
            case "GET":
                $api = new GET($this->getContainer(), $this->getModel());
                $GET = $this->getRequest()->getQueryParams();
                $id = (int) $this->getRoute()->getParam("id");
                $data = $api->run($id, $GET);
                break;
            case "DELETE":
                $api = new DELETE($this->getContainer(), $this->getModel());
                $id = (int) $this->getRoute()->getParam("id");
                $data = $api->run($id);
                break;
            case "PUT":
                $api = new PUT($this->getContainer(), $this->getModel());
                $id = (int) $this->getRoute()->getParam("id");
                $put = $this->data_HTTP();
                $routeFile = "";
                $IconShowFiles = $this->save_files($routeFile);
                $data = $api->run($id, $put, $IconShowFiles);
                break;
            case "POST":
                $api = new POST($this->getContainer(), $this->getModel());
                $post = $this->data_HTTP();
                $routeFile = "";
                $IconShowFiles = $this->save_files($routeFile);
                $data = $api->run($post, $IconShowFiles);
                break;
        }
        return $this->json($data);
    }

    public function json($data) {
       if( !is_string($data)){
         $data = Tools::json_js($data);  
        }
        
        $this->getResponse()->getBody()->write($data);
        return $this->getResponse()->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

    ////////////////////////////////////////////////////////////////////////
    private function data_HTTP(): array {
        /**
         * get data send
         *
         */
        $POST = $this->getRequest()->getParsedBody();

        if (!empty($POST)) {
            $data = $POST;
        } else {

            $PUT = json_decode(file_get_contents('php://input'), true);

            $data = $PUT;
        }
       
        /**
         * ecypte password
         */
        $dataencrypt = $this->encryptPassword($data);
        return $dataencrypt;
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

    //////////////////////////////////////////////////////////////////////////
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

}
