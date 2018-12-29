<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

use Kernel\AWA_Interface\Base_Donnee\SetDataInterface;
use Kernel\INTENT\Intent_Set;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Tools\Tools;
use TypeError;
use function array_keys;
use function date;

/**
 * Description of SetData
 *
 * @author wassime
 */
class SetData extends Select_Fonctions implements SetDataInterface
{
 ///////////////////////////////////////////////////////////
    /**
     * delete one item get id delete
     * @param array $condition
     * @return int
     */

    public function delete(array $condition): int
    {
        // one  item
        
        $delete = self::Get_QuerySQL()
                ->delete($this->getTable())
                ->where($condition)
                ->prepareQuery();
        return $this->prepareEXEC($delete);
    }

    /**
     * lier table par childe
     *  exec SQL des tables relations
     * @param string $id_Table
     * @param array $Data_CHILDREN_id
     */
    public function insert_Relation_childe(string $id_Table, array $Data_CHILDREN_id, string $table = "")
    {
        if ($table == "") {
            $table = $this->getTable();
        }


        foreach ($Data_CHILDREN_id as $name_table_CHILDREN => $id_CHILDRENs) {
            foreach ($id_CHILDRENs as $id_CHILD) {
                $querySQL = self::Get_QuerySQL()->
                                insertInto("r_" . $table . "_" . $name_table_CHILDREN)
                                ->value([
                                    "id_" . $table => $id_Table,
                                    "id_" . $name_table_CHILDREN => $id_CHILD
                                ])->prepareQuery();
                $this->prepareEXEC($querySQL);
            }
        }
    }

    /**
     * supprimer lieson de table par childe
     *  exec SQL des tables relations
     * @param string $id_Table
     */
    public function delete_Relation_childe(string $id_Table)
    {
        $name_CHILDRENs = (array_keys($this->getschema()->getCHILDREN())); // name childern array

        foreach ($name_CHILDRENs as $name_table_CHILDREN) {
            $sqlquery = self::Get_QuerySQL()
                    ->delete("r_" . $this->getTable() . "_" . $name_table_CHILDREN)
                    ->where(["id_" . $this->getTable() => $id_Table])
                    ->prepareQuery();
            $this->prepareEXEC($sqlquery);
        }
    }

    /////////////////////////////
    /**
     * crier Intent_Set par data set par form
     * $data set par form
     * @param array $data
     * @return Intent_Set
     * @throws TypeError
     */
    public function parse(array $data): Intent_Set
    {
        $schema = $this->getschema();
        if (Tools::isAssoc($data) and isset($data)) {
            return (new Intent_Set($schema, ((new EntitysDataTable())->set($data))));
        } else {
            throw new TypeError("erreur data set is empty or not arrayAssoc ");
        }
    }

    /**
     *
     * @param array $dataForm
     * @return int
     */
    public function update(array $dataForm): int
    {
        $intent_set = $this->parse($dataForm);
        $Data_CHILDREN_id = $intent_set->get_Data_CHILDREN_id();
        $data_table = $intent_set->get_Data_Table();

        $id_Table = $data_table["id"];
        unset($data_table["id"]);   // remove id
        // exec query sql insert to NameTable table
        $datenow = date("Y-m-d-H-i-s");
        $data_table["date_modifier"] = $datenow;
        $querySQL = self::Get_QuerySQL()->
                update($this->getTable())
                ->set($data_table)
                ->where(["id" => $id_Table])
                ->prepareQuery();
        $this->prepareEXEC($querySQL);
        /**
         * code delete insert  data to relation table
         */
        //delete childe
        $this->delete_Relation_childe($id_Table);
        //insert
        $this->insert_Relation_childe($id_Table, $Data_CHILDREN_id);
        return $id_Table;
    }

    /**
     * insert data inverse set data_table et set_relation
     * @param array $dataForm
     * @return int
     */
    public function insert_table_Relation(array $dataForm): int
    {


        $intent_set = $this->parse($dataForm);
        $Data_CHILDREN_id = $intent_set->get_Data_CHILDREN_id();
        $data_table = $intent_set->get_Data_Table();


        unset($data_table["id"]);   // remove id
        // exec query sql insert to NameTable table
        $datenow = date('Y-m-d H:i:s');
        $data_table["date_ajoute"] = $datenow;
        $data_table["date_modifier"] = $datenow;

        $querySQL = self::Get_QuerySQL()
                ->insertInto($this->getTable())
                ->value($data_table)
                ->prepareQuery();
        // return id rowe set data NameTable table

        $id_Table = $this->prepareEXEC($querySQL);
        /**
         * code insert data to relation table
         */
        $this->insert_Relation_childe($id_Table, $Data_CHILDREN_id);
        return $id_Table;
    }

    /**
     * insert data inverse set data_childe et set_relation
     * @param array $dataForms
     * @param int $id_table_parent
     * @param string $table_parent
     * @return int
     */
    public function insert_tableChilde_Relation(array $dataForms, int $id_table_parent, string $table_parent = ""): int
    {
        $id_cheldrns = [];
        $table = $this->getTable();
        if ($table_parent == "") {
            $table_parent = $this->getTable() . "s";
        }
        /**
         * insert data table child
         */
        foreach ($dataForms as $dataForm) {
            $id_cheldrns[] = $this->insert_table_Relation($dataForm);
        }
        /**
         * code insert data to relation table
         */
        $this->insert_Relation_childe($id_table_parent, [$table => $id_cheldrns], $table_parent);


        return $id_table_parent;
    }
}
