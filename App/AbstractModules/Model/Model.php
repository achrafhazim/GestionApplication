<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author wassime
 */

namespace App\AbstractModules\Model;

use Kernel\Model\Model as m;
use Kernel\ToolsView\INTENT\Intent_Form;
use Kernel\ToolsView\INTENT\Intent_Show;

class Model extends m
{
    ////select input simple

    /**
     * $id entity save => id_FOREIGN_KEY
     * @param type $id_save
     * @return array assoc  exemple ['raison$sociale' =>  '24',...]
     */
    public function get_id_FOREIGN_KEYs($id_save): array
    {

        $FOREIGN_KEYs = $this->getschema()
            ->getFOREIGN_KEY();
        if (empty($FOREIGN_KEYs)) {
            return [];
        }

        $Entitys = $this->select_simple($FOREIGN_KEYs, $id_save);

        // is vide
        if (isset($Entitys[0])) {
            return $Entitys[0];
        }

        return [];
    }

    /**
     * pour form select or select input
     * @param array $id_FOREIGN_KEYs exemple ['raison$sociale' =>  '24',...]
     * @param array $mode
     * @return array
     */
    public function get_Data_FOREIGN_KEY(array $id_FOREIGN_KEYs = [], array $mode = self::MODE_SELECT_MASTER_NULL): array
    {
        /// charge select input
        $Entitys_FOREIGNs = [];

        foreach ($this->getschema()->getFOREIGN_KEY() as $nameTable_FOREIGN) {
            // get condition
            //$id_FOREIGN_KEYs   exemple ['raison$sociale' =>  '24',....]
            if (empty($id_FOREIGN_KEYs) || !isset($id_FOREIGN_KEYs[$nameTable_FOREIGN])) {
                $conditions = true;
            } else {
                $conditions = [];
                $id = $id_FOREIGN_KEYs[$nameTable_FOREIGN];
                $conditions[$nameTable_FOREIGN . ".id"] = $id;
            }

            // get data
            $shema_FOREIGN = $this->getschema($nameTable_FOREIGN);
            $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->find(
                $conditions,
                $mode,
                $shema_FOREIGN
            );
        }

        return $Entitys_FOREIGNs;
    }

    public function get_Data_FOREIGN_KEY__ID($id_save): array
    {
        //select id de FOREIGN_KEY lier to table
        $id_FOREIGN_KEYs = $this->get_id_FOREIGN_KEYs($id_save);
        // select data de FOREIGN_KEY
        return $this->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs);
    }

////multiselect input

    /**
     *
     * @param array $id_FOREIGN_KEYs   exemple ['raison$sociale' =>  '24']
     * @param array $mode
     * @return array
     */
    public function dataChargeMultiSelectIndependent(array $id_FOREIGN_KEYs = [], array $mode = self::MODE_SELECT_ALL_MASTER): array
    {

        $Entitys_CHILDRENs = [];

        foreach ($this->getschema()->get_table_CHILDREN() as $table_CHILDREN) {
            if (empty($id_FOREIGN_KEYs)) {
                $conditions = true;
            } else {
                $conditions = [];
                // independent FOREIGN_KEY
                //array (size=1) 0 => string 'raison$sociale'
                foreach ($this->getschema($table_CHILDREN)->getFOREIGN_KEY() as $FOREIGN_KEY) {
                    if (isset($id_FOREIGN_KEYs[$FOREIGN_KEY])) {
                        $id = $id_FOREIGN_KEYs[$FOREIGN_KEY];
                        $conditions[$FOREIGN_KEY . ".id"] = $id; // exemple ['raison$sociale.id' =>  '24',....]
                    }
                }
                if (empty($conditions)) {
                    $conditions = true;
                }
            }

            $Entitys_CHILDRENs[$table_CHILDREN] = $this->prepareQuery(
                self::Get_QuerySQL()
                    ->select($this->getschema()->select_CHILDREN($table_CHILDREN, $mode[1]))
                    ->from($table_CHILDREN)
                    ->join($this->getschema($table_CHILDREN)->getFOREIGN_KEY()) //array [ 0 =>  'raison$sociale']
                    ->independent($this->getTable()) // independent table not lier
                    ->where($conditions) // lier FOREIGN_KEY
                    ->prepareQuery()

            );

        }

        return $Entitys_CHILDRENs;
    }

    /**
     * test select libr champ
     * /chld/...?pr=
     * http://localhost/api/commandes?schema=p&pr=bons$achats&con=raison$sociale.id=1
     * @param type $perant
     * @param type $conditions
     * @return type
     */
    public function libre($perant, $conditions = true)
    {
        
         $d=   self::Get_QuerySQL()
                ->select()
                ->column($this->schema->select_default())
            //->column($this->schema->select_FOREIGN_KEY())

                ->from($this->getTable())
                ->join($this->schema->getFOREIGN_KEY()) //array [ 0 =>  'raison$sociale']
                ->independent($perant) // independent table not lier
                ->where($conditions) // lier FOREIGN_KEY
                ->prepareQuery()

        ;
      //  var_dump($d->getPrepare());die();
        return $this->prepareQuery($d);

    }

    /**
     * http://localhost/api/commandes?schema=s&pr=bons$achats&id=1
     * @param type $perant
     * @param type $id
     * @return type
     */

    public function save($perant, $id)
    {
        $tablechild = $this->getTable();
        $d = $this->prepareQuery(
            self::Get_QuerySQL()
                ->select()
                ->column($this->getschema($tablechild)->select_default())
            // ->column($this->getschema("r_commandes_articles")->select_default())
                ->from($perant)
                ->join($tablechild, " INNER ", true)
                ->join($this->getschema($tablechild)->getFOREIGN_KEY(), " INNER ", false, "", $tablechild)
                ->where($perant . ".id = " . $id)
                ->prepareQuery()
        );
      //  var_dump($d);
        return $d;
    }
    /**
     *
     * @param type $id_save
     * @param array $mode
     * @return type
     */
    private function get_Charge_multiSelect($id_save, array $mode = self::MODE_SELECT_ALL_DEFAULT)
    {
        //select id de FOREIGN_KEY lier to table
        $id_FOREIGN_KEYs = $this->get_id_FOREIGN_KEYs($id_save);
        // select data de MultiSelect || tablechilde
        return $this->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $mode);
    }

    /**
     *
     * @param type $id
     * @param type $modeselect
     * @return Intent_Form
     */
    public function show_styleForm($id, $modeselect = self::MODE_SELECT_ALL_DEFAULT): Intent_Form
    {

        $schema = $this->getschema();

        $Entitys = $this->find_by_id($id, $modeselect, $schema);
        if ($Entitys->is_Null()) {
            var_dump("show_styleForm");
            die("<h1>bbbbbbbbbbbbbbdonnees vide car je ne peux pas insérer données  doublons ou vide </h1> ");
        }

        $intent_Form = new Intent_Form();
        $intent_Form->setDefault_Data($Entitys);
        $intent_Form->setCharge_data_select($this->get_Data_FOREIGN_KEY__ID($id));
        $intent_Form->setCharge_data_multiSelect($this->get_Charge_multiSelect($id, $modeselect));
        $intent_Form->setCOLUMNS_META($schema->getCOLUMNS_META());

        return $intent_Form;
    }

    /**
     * self::mode
     * @param array $mode
     * @param array $rangeID
     * @return Intent_Show
     */
    public function show_in(array $mode, $rangeID): Intent_Show
    {
        //range
        if (is_string($rangeID)) {
            $rangeID = explode(",", $rangeID);
        }
        $schema = $this->getSchema();
        $Entitys = $this->select_in($rangeID, $mode, $schema);
        return new Intent_Show($schema, $Entitys, $mode);
    }

    /**
     * self::mode
     * @param array $mode
     * @param type $id
     * @return Intent_Show
     */
    public function show(array $mode, $id = true): Intent_Show
    {

        $schema = $this->getSchema();
        $Entitys = $this->find($id, $mode);

        return new Intent_Show($schema, $Entitys, $mode);
    }

// save data

    public function setData(array $data, $table_parent = "", $id_perent = 0)
    {

        if (!empty($data)) {
            if ($id_perent === 0) {
                if (!isset($data['id']) || $data['id'] == "") {
                    $id_parent = $this->insert_table_Relation($data);
                } else {
                    $id_parent = $this->update($data);
                }
            } else {
                $id_parent = $this->insert_tableChilde_Relation($data, $id_perent, $table_parent);
            }
            return ($id_parent);
        } else {
            die(" data to server php is empty show code html or ajax =>erreur send data");
        }
    }

}
