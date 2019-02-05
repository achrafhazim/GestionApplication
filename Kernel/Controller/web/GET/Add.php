<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller\web\GET;

use Kernel\ToolsView\INTENT\Intent_Form;

/**
 * Description of add
 *
 * @author wassim
 */
class Add {

    private $model;
    private $GET;
    private $notSelect;
    private $Child;

    function __construct($model, $GET, $notSelect, $Child) {
        $this->model = $model;
        $this->GET = $GET;
        $this->notSelect = $notSelect;
        $this->Child = $Child;
    }

    public function run() {
        //hhhhhhhhhhhhhhhhhhh tamara
         return $this->ajouter_child();
        if ($this->Child !== false) {
            return $this->ajouter_child();
        } else {
            return $this->ajouter();
        }
    }

    public function ajouter() {
        $model = $this->model;
        $schema = $model->getschema();

        $data_get = $this->GET;
        $NotSelect = $this->notSelect;


        $META_data = $schema->getCOLUMNS_META(["Key" => "MUL"], ["Field" => $NotSelect]);


        if (empty($data_get) && !empty($META_data)) {
            $select = $model->get_Data_FOREIGN_KEY();
           $intent_formselect = new Intent_Form();
            $intent_formselect->setCOLUMNS_META($META_data);
            $intent_formselect->setCharge_data_select($select);
            return ["type" => "select", "intent" => $intent_formselect];
         //   return $this->render($viewSelect, ["intent" => $intent_formselect]);
        } else {
            $intent_form = new Intent_Form();
            $META_data = $schema->getCOLUMNS_META();
            
            $intent_form->setCOLUMNS_META($META_data);
            
            $select = $model->get_Data_FOREIGN_KEY($data_get);
            $intent_form->setCharge_data_select($select);
            $table_CHILDREN=$model->getschema()->get_table_CHILDREN();
            
            
            
            
            $multiSelect = $model->dataChargeMultiSelectIndependent($data_get);
            $intent_form->setCharge_data_multiSelect($multiSelect);

            
            
            
            return ["type" => "ajouter", "intent" => $intent_form];
           // return $this->render($viewAjoutes, ["intent" => $intent_form]);
        }
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /*     * ***
     * child
     */

    public function ajouter_child() {
        $model = $this->model;
        $schema = $model->getschema();

        $data_get = $this->GET;
        $NotSelect = $this->notSelect;

        $META_data = $schema->getCOLUMNS_META(["Key" => "MUL"], ["Field" => $NotSelect]);


        if (empty($data_get) && !empty($META_data)) {
            $select = $model->get_Data_FOREIGN_KEY();
            $intent_formselect = new Intent_Form();
            $intent_formselect->setCOLUMNS_META($META_data);
            $intent_formselect->setCharge_data_select($select);
            return ["type" => "select", "intent" => $intent_formselect];
            //return $this->render($viewSelect, ["intent" => $intent_formselect]);
        } else {
            $model = $this->model;
            $schema = $model->getschema();
            $META_data = $schema->getCOLUMNS_META();
            $select = $model->get_Data_FOREIGN_KEY($data_get);
            $multiSelect = $model->dataChargeMultiSelectIndependent($data_get);

            $intent_form = new Intent_Form();
            $intent_form->setCOLUMNS_META($META_data);
            $intent_form->setCharge_data_select($select);
            $intent_form->setCharge_data_multiSelect($multiSelect);




            $NameControllerchild = $this->Child;
            $this->model->setTable($NameControllerchild);

            $model = $this->model;
            $schema = $model->getschema();
            $META_data = $schema->getCOLUMNS_META();
            $select = $model->get_Data_FOREIGN_KEY($data_get);
            $multiSelect = $model->dataChargeMultiSelectIndependent($data_get);

            $intentformchile = new Intent_Form();
            $intentformchile->setCOLUMNS_META($META_data);
            $intentformchile->setCharge_data_select($select);
            $intentformchile->setCharge_data_multiSelect($multiSelect);
            return ["type" => "form_child", "intent" => $intent_form, "intentchild" => $intentformchile];
            //return $this->render($viewAjoutes, ["intent" => $intent_form, "intentchild" => $intentformchile]);
        }
    }

}
