<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\AWA_Interface\Base_Donnee;

use Kernel\INTENT\Intent_Set;
use TypeError;

/**
 *
 * @author wassime
 */
interface SetDataInterface
{
     ///////////////////////////////////////////////////////////
    /**
     * delete one item get id delete
     * @param array $condition
     * @return int
     */

    public function delete(array $condition): int ;

    /**
     * lier table par childe
     *  exec SQL des tables relations
     * @param string $id_Table
     * @param array $Data_CHILDREN_id
     */
    public function insert_Relation_childe(string $id_Table, array $Data_CHILDREN_id, string $table = "") ;
    /**
     * supprimer lieson de table par childe
     *  exec SQL des tables relations
     * @param string $id_Table
     */
    public function delete_Relation_childe(string $id_Table) ;

    /////////////////////////////
    /**
     * crier Intent_Set par data set par form
     * $data set par form
     * @param array $data
     * @return Intent_Set
     * @throws TypeError
     */
    public function parse(array $data): Intent_Set ;

    /**
     *
     * @param array $dataForm
     * @return int
     */
    public function update(array $dataForm): int ;

    /**
     * insert data inverse set data_table et set_relation
     * @param array $dataForm
     * @return int
     */
    public function insert_table_Relation(array $dataForm): int ;

    /**
     * insert data inverse set data_childe et set_relation
     * @param array $dataForms
     * @param int $id_table_parent
     * @param string $table_parent
     * @return int
     */
    public function insert_tableChilde_Relation(array $dataForms, int $id_table_parent, string $table_parent = ""): int ;
}
