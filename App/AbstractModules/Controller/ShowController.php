<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\Event\Event;
use Kernel\INTENT\Intent_Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Kernel\Tools\Tools;
use function substr;

class ShowController extends AbstractController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        $this->setRoute($this->getRouter()->match($this->getRequest()));

        $this->setNameController($this->getRoute()->getParam("controle"));






        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }
        $action = $this->getRoute()->getParam("action");
        $this->Actions()->setAction($action);
        $id = $this->getRoute()->getParam("id");



        return $this->run($id);
    }

    public function run($id): ResponseInterface {
        switch (true) {
            case $this->Actions()->is_ajax():
                return $this->ajax_js();
            case $this->Actions()->is_index():
                return $this->showDataTable("show", $this->getNamesRoute()->ajax());


            case $this->Actions()->is_update():
                if ($this->getChild() !== false) {
                    return $this->modifier_child($id, "modifier_form_child");
                } else {
                    return $this->modifier($id, "modifier_form");
                }


            case $this->Actions()->is_delete():
                return $this->supprimer($id, "les données a supprimer de ID");


            case $this->Actions()->is_show():
                return $this->show($id, "show_id");


            case $this->Actions()->is_message():
                return $this->message($id, "show_message_id");


            case $this->Actions()->is_add():
                if ($this->getChild() !== false) {
                    return $this->ajouter_child("ajouter_form_child", "ajouter_select");
                } else {
                    return $this->ajouter("ajouter_form", "ajouter_select");
                }



            default:
                return $this->getResponse()->withStatus(404);
        }
    }

  

    protected function showDataTable(string $name_views, string $nameRouteGetDataAjax): ResponseInterface {

        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }

        $query = $this->getRequest()->getQueryParams();
        $modeshow = $this->getModeShow($query);
        $modeSelect = $modeshow["modeSelect"];

        $data = [
            "Html_or_Json" => $modeshow["type"],
            "btnDataTable" => $this->btn_DataTable($query)["btn"],
            "jsCharges" => $this->btn_DataTable($query)["jsCharges"],
            "modeSelectpere" => $modeSelect[0],
            "modeSelectenfant" => $modeSelect[1]
        ];


        if ($modeshow["type"] === "HTML") {
            $data["intent"] = $this->getModel()->show($modeSelect, true);
        } elseif ($modeshow["type"] === "json") {
            $url = $this->getRouter()
                    ->generateUri($nameRouteGetDataAjax, ["controle" => $this->getNameController()]);

            $get = "?" . $this->getRequest()->getUri()->getQuery();
            $data["ajax"] = $url . $get;
        }


        return $this->render($name_views, $data);
    }

    private function btn_DataTable(array $modeHTTP): array {

        $param = "pageLength colvis";
        $jsCharge = [];
        if (isset($modeHTTP["copier"]) && $modeHTTP["copier"] == "on") {
            $param .= " copyHtml5";
            $jsCharge["copier"] = true;
        }
        if (isset($modeHTTP["pdf"]) && $modeHTTP["pdf"] == "on") {
            $param .= " pdfHtml5";
            $jsCharge["pdf"] = true;
        }
        if (isset($modeHTTP["excel"]) && $modeHTTP["excel"] == "on") {
            $param .= " excelHtml5";
            $jsCharge["excel"] = true;
        }
        if (isset($modeHTTP["impression"]) && $modeHTTP["impression"] == "on") {
            $param .= " print";
            $jsCharge["print"] = true;
        }
        $param .= " control";

        return ["btn" => $param, "jsCharges" => $jsCharge];
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////


}
