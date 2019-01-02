<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller;

use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\Event\Event;
use Kernel\INTENT\Intent_Form;
use Psr\Http\Message\ResponseInterface;
use const ROOT_WEB;
use function array_merge;
use function str_replace;
use function substr;

/**
 * Description of WebController
 *
 * @author wassime
 */
class WebController extends Controller {
    
        /// view
    function add_data_views(array $data_views): array {

        $this->data_views = array_merge($this->data_views, $data_views);
        return $this->data_views;
    }

    function getFile_Upload(): File_UploadInterface {
        return $this->File_Upload;
    }

    function getRenderer(): RendererInterface {
        return $this->renderer;
    }

    function setFile_Upload(File_UploadInterface $File_Upload) {
        $this->File_Upload = $File_Upload;
    }

    function setRenderer(RendererInterface $renderer) {
        $this->renderer = $renderer;
    }

    public function render($name_view, array $data = []): ResponseInterface {
        $renderer = $this->getRenderer();

        $renderer->addGlobal("_page", ucfirst(str_replace("$", "  ", $this->getNameController())));
        $renderer->addGlobal("_Controller", $this->getNameController());
        $renderer->addGlobal("_Action", $this->Actions());
        $renderer->addGlobal("_ROOTWEB", ROOT_WEB);

        $renderer->addGlobal("_NamesRoute", $this->getNamesRoute());
        $data_view = $this->add_data_views($data);


        $pathview = $this->getContainer()->get("Modules") .
                $this->getNameModule() . D_S .
                "views" . D_S .
                $this->getNameController() . D_S;

        if (is_dir($pathview)) {
            $render = $renderer->render("@{$this->getNameModule()}{$this->getNameController()}/" . $name_view, $data_view);
        } else {
            $render = $renderer->render("@default_view/" . $name_view, $data_view);
        }



        $response = $this->getResponse();
        $response->getBody()->write($render);
        return $response;
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
