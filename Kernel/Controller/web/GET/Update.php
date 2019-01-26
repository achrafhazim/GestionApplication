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
namespace Kernel\Controller\web\GET;
use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\Event\Event;
use Kernel\INTENT\Intent_Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Kernel\Controller\WebController;
use function substr;
class Update {
   private $model;
 
    private $Child;

    function __construct($model, $Child) {
        $this->model = $model;
      
        $this->Child = $Child;
    }

    public function run($id) {
        if ($this->Child !== false) {
            return $this->modifier_child($id);
        } else {
            return $this->modifier($id);
        }
    }
    
    protected function modifier($id_save) {


        $modeselect = $this->model::MODE_SELECT_ALL_MASTER;
        $model = $this->model;

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

        return ["type"=>"form","intent" => $intent_Form];





      //  return $this->render($view, ["intent" => $intent_Form]);
    }



    protected function modifier_child($id_save) {


        $model = $this->model;
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
        var_dump("nadar");die();
        $Controllerchild = substr($this->getNameController(), 0, -1); // childe achats => achat
        $this->chargeModel($Controllerchild);
        $model_Child = $this->model;
        $schema_Child = $model_Child->getschema();

        $intent_formChile = new Intent_Form();
        $intent_formChile->setCharge_data_select($model_Child->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs));
        $intent_formChile->setCharge_data_multiSelect($model_Child->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $modeselect));
        $intent_formChile->setCOLUMNS_META($schema_Child->getCOLUMNS_META());

return ["type"=>"form_child","intent" => $intent_Form, "intentchild" => $intent_formChile];
       // return $this->render($view, ["intent" => $intent_Form, "intentchild" => $intent_formChile]);
    }
}
