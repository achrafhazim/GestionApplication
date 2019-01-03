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
use function substr;

 class ShowController extends AbstractController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        if ($this->getResponse()->getStatusCode() != 200) {
            return $this->getResponse();
        }
        $this->setRoute($this->getRouter()->match($this->getRequest()));
        $this->setNameController($this->getRoute()->getParam("controle"));

      $classModel = $this->getClassModel();

        $this->setModel(new $classModel($this->getContainer()->get("pathModel"), $this->getContainer()->get("tmp")));
        $this->chargeModel($this->getNameController());


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
    protected function supprimer($id, string $view): ResponseInterface {

        $conditon = ['id' => $id];

        $url_id_file = $this->getModel()->get_idfile($id);

        $etat = $this->getModel()->delete($conditon);

        if ($etat == -1) {
            $r = $this->getResponse()->withStatus(406);
            $r->getBody()->write("accès refusé  de supprimer ID  $id");
            return $r;
        } else {
            $this->getResponse()->getBody()->write("$view  $id");

            $eventManager = $this->getContainer()->get(EventManagerInterface::class);
            $event = new Event();
            $event->setName("delete_files");
            $event->setParams(["url_id_file" => $url_id_file]);
            $eventManager->trigger($event);
        }

        return $this->getResponse();
    }

    protected function modifier($id_save, string $view): ResponseInterface {


        $modeselect = $this->getModel()::MODE_SELECT_ALL_MASTER;
        $model = $this->getModel();

        $schema = $model->getschema();

        $Entitys = $model->find_by_id($id_save, $modeselect, $schema);

        if ($Entitys->is_Null()) {
            die("<h1>donnees vide car je ne peux pas insérer données  doublons ou vide </h1> ");
        }

        $intent_Form = new Intent_Form();
        $intent_Form->setDefault_Data($Entitys);
        $id_FOREIGN_KEYs = $model->get_id_FOREIGN_KEYs($id_save);


        $intent_Form->setCharge_data_select($model->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs));
        $intent_Form->setCharge_data_multiSelect($model->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $modeselect));
        $intent_Form->setCOLUMNS_META($schema->getCOLUMNS_META());







        return $this->render($view, ["intent" => $intent_Form]);
    }

    protected function ajouter(string $viewAjoutes, string $viewSelect): ResponseInterface {
        $model = $this->getModel();
        $schema = $model->getschema();

        $data_get = $this->getRequest()->getQueryParams();
        $NotSelect = $this->getnotSelect();


        $META_data = $schema->getCOLUMNS_META(["Key" => "MUL"], ["Field" => $NotSelect]);


        if (empty($data_get) && !empty($META_data)) {
            $select = $model->get_Data_FOREIGN_KEY();



            $intent_formselect = new Intent_Form();
            $intent_formselect->setCOLUMNS_META($META_data);
            $intent_formselect->setCharge_data_select($select);
            return $this->render($viewSelect, ["intent" => $intent_formselect]);
        } else {
            $META_data = $schema->getCOLUMNS_META();
            $select = $model->get_Data_FOREIGN_KEY($data_get);
            $multiSelect = $model->dataChargeMultiSelectIndependent($data_get);

            $intent_form = new Intent_Form();
            $intent_form->setCOLUMNS_META($META_data);
            $intent_form->setCharge_data_select($select);
            $intent_form->setCharge_data_multiSelect($multiSelect);


            return $this->render($viewAjoutes, ["intent" => $intent_form]);
        }
    }

    protected function show($id, string $view): ResponseInterface {
        $intent = $this->getModel()->show_styleForm($id);
        return $this->render($view, ["intent" => $intent]);
    }

    protected function message($rangeID, string $view): ResponseInterface {

        $mode = $this->getModel()::MODE_SELECT_DEFAULT_NULL;

        $intentshow = $this->getModel()->show_in($mode, $rangeID);

        return $this->render($view, ["intent" => $intentshow]);
    }

    /*     * ***
     * child
     */

    protected function ajouter_child(string $viewAjoutes, string $viewSelect): ResponseInterface {
        $model = $this->getModel();
        $schema = $model->getschema();

        $data_get = $this->getRequest()->getQueryParams();
        $NotSelect = $this->getnotSelect();

        $META_data = $schema->getCOLUMNS_META(["Key" => "MUL"], ["Field" => $NotSelect]);


        if (empty($data_get) && !empty($META_data)) {
            $select = $model->get_Data_FOREIGN_KEY();
            $intent_formselect = new Intent_Form();
            $intent_formselect->setCOLUMNS_META($META_data);
            $intent_formselect->setCharge_data_select($select);
            return $this->render($viewSelect, ["intent" => $intent_formselect]);
        } else {
            $model = $this->getModel();
            $schema = $model->getschema();
            $META_data = $schema->getCOLUMNS_META();
            $select = $model->get_Data_FOREIGN_KEY($data_get);
            $multiSelect = $model->dataChargeMultiSelectIndependent($data_get);

            $intent_form = new Intent_Form();
            $intent_form->setCOLUMNS_META($META_data);
            $intent_form->setCharge_data_select($select);
            $intent_form->setCharge_data_multiSelect($multiSelect);




            $NameControllerchild = $this->getChild();
            $this->getModel()->setTable($NameControllerchild);

            $model = $this->getModel();
            $schema = $model->getschema();
            $META_data = $schema->getCOLUMNS_META();
            $select = $model->get_Data_FOREIGN_KEY($data_get);
            $multiSelect = $model->dataChargeMultiSelectIndependent($data_get);

            $intentformchile = new Intent_Form();
            $intentformchile->setCOLUMNS_META($META_data);
            $intentformchile->setCharge_data_select($select);
            $intentformchile->setCharge_data_multiSelect($multiSelect);

            return $this->render($viewAjoutes, ["intent" => $intent_form, "intentchild" => $intentformchile]);
        }
    }

    protected function modifier_child($id_save, string $view): ResponseInterface {


        $model = $this->getModel();
        $modeselect = $model::MODE_SELECT_ALL_MASTER;

        $schema = $model->getschema();

        $Entitys = $model->find_by_id($id_save, $modeselect, $schema);

        if ($Entitys->is_Null()) {
            die("<h1>donnees vide car je ne peux pas insérer données  doublons ou vide </h1> ");
        }

        $intent_Form = new Intent_Form();
        $intent_Form->setDefault_Data($Entitys);
        $id_FOREIGN_KEYs = $model->get_id_FOREIGN_KEYs($id_save);


        $intent_Form->setCharge_data_select($model->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs));
        $intent_Form->setCharge_data_multiSelect($model->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $modeselect));
        $intent_Form->setCOLUMNS_META($schema->getCOLUMNS_META());



        //****************************************//

        $Controllerchild = substr($this->getNameController(), 0, -1); // childe achats => achat
        $this->chargeModel($Controllerchild);
        $model_Child = $this->getModel();
        $schema_Child = $model_Child->getschema();

        $intent_formChile = new Intent_Form();
        $intent_formChile->setCharge_data_select($model_Child->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs));
        $intent_formChile->setCharge_data_multiSelect($model_Child->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $modeselect));
        $intent_formChile->setCOLUMNS_META($schema_Child->getCOLUMNS_META());


        return $this->render($view, ["intent" => $intent_Form, "intentchild" => $intent_formChile]);
    }

}
