<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

use Kernel\AWA_Interface\Base_Donnee\MODE_SELECT_Interface;
use Kernel\Tools\Tools;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of GETcontroller
 *
 * @author wassime
 */
class GETcontroller extends AbstractController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        $this->setRoute($this->getRouter()->match($this->getRequest()));
        $this->setNameController($this->getRoute()->getParam("controle"));
        $id=(int)$this->getRoute()->getParam("id");
        
       

        $classModel = $this->getClassModel();
        $this->setModel(new $classModel($this->getContainer()->get("pathModel"), $this->getContainer()->get("tmp")));
        $this->chargeModel($this->getNameController());


        if ($this->is_Erreur()) {
            return $this->getResponse()
                            ->withStatus(404)
                            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        }


        return $this->ajax_js($id);
    }

 

    public function desplayType(array $query) {
        if (isset($query["desplayType"])) {
            return $query["desplayType"];
        }
        return "json";
    }

    public function condition(array $query) {
        if (isset($query["condition"])) {
            return $query["condition"];
        }
         if (isset($query["where"])) {
            return $query["where"];
        }
        return "id>0";
    }

      public function ajax_js($id): ResponseInterface {
          $query = $this->getRequest()->getQueryParams();
        
          if ($id==0) {
              $condition = $this->condition($query);
              
          } else {
              $condition="id<$id";
          }
           

        
        $modeshow = $this->getModeShow($query);
        $desplayType = $this->desplayType($query);
       //  $fitlre = $this->fitlre($query);
        //$limit = $this->limit($query);
        // $ordeby = $this->ordeby($query);
        




        $modeSelect = $modeshow["modeSelect"];

        $Model= $this->getModel();
        
        $data=$Model->showAjax($modeSelect, $condition);
        //var_dump($condition);die();
        $json = Tools::json_js($data);
        $this->getResponse()->getBody()->write($json);
        return $this->getResponse()->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

    protected function getModeShow(array $modeHTTP): array {

        $parent = MODE_SELECT_Interface::_DEFAULT;
        $child = MODE_SELECT_Interface::_NULL;

        $type = "json";
        if (isset($modeHTTP["pere"])) {
            $parent = $this->parseMode($modeHTTP["pere"], $parent);
        }
        if (isset($modeHTTP["fils"])) {
            $child = $this->parseMode($modeHTTP["fils"], $child);
            if ($child != MODE_SELECT_Interface::_NULL) {
                $type = "HTML";
            }
        }


        return ["type" => $type, "modeSelect" => [$parent, $child]];
    }

    private function parseMode(string $modefr, $default): string {
        switch ($modefr) {
            case "rien":
                $mode = MODE_SELECT_Interface::_NULL;
                break;
            case "resume":
                $mode = MODE_SELECT_Interface::_MASTER;
                break;
            case "defaut":
                $mode = MODE_SELECT_Interface::_DEFAULT;
                break;
            case "tous":
                $mode = MODE_SELECT_Interface::_ALL;
                break;

            default:
                $mode = $default;
                break;
        }
        return $mode;
    }

}
