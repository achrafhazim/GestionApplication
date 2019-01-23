<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Update
 *
 * @author wassim
 */
namespace Kernel\Controller\web;
use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\Event\Event;
use Kernel\INTENT\Intent_Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Kernel\Controller\WebController;
use function substr;
class Update {
    public function run( $controller,  $id,$view) {}
    
    protected function modifier($id_save, string $view): ResponseInterface {


        $modeselect = $this->getModel()::MODE_SELECT_ALL_MASTER;
        $model = $this->getModel();

        $schema = $model->getschema();

        $Entitys = $model->find_by_id($id_save, $modeselect, $schema);

        if ($Entitys->is_Null()) {
            var_dump("modifier");
            die("<h1>bbbbbbbbbbbbbbdonnees vide car je ne peux pas insérer données  doublons ou vide </h1> ");
        }

        $intent_Form = new Intent_Form();
        $intent_Form->setDefault_Data($Entitys);
        $id_FOREIGN_KEYs = $model->get_id_FOREIGN_KEYs($id_save);


        $intent_Form->setCharge_data_select($model->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs));
        $intent_Form->setCharge_data_multiSelect($model->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $modeselect));
        $intent_Form->setCOLUMNS_META($schema->getCOLUMNS_META());







        return $this->render($view, ["intent" => $intent_Form]);
    }



    protected function modifier_child($id_save, string $view): ResponseInterface {


        $model = $this->getModel();
        $modeselect = $model::MODE_SELECT_ALL_MASTER;

        $schema = $model->getschema();

        $Entitys = $model->find_by_id($id_save, $modeselect, $schema);

        if ($Entitys->is_Null()) {
            var_dump("modifier_child");
            die("<h1>cccccccccccccccccccdonnees vide car je ne peux pas insérer données  doublons ou vide </h1> ");
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
