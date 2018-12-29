<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\AWA_Interface\Base_Donnee;

use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;

/**
 *
 * @author wassime
 */
interface SelectInterface extends MODE_SELECT_Interface
{

    /**
     * get id (exmple:<a class="btn "  role="button" href="/CRM/files/clients_2018-08-01-16-32-12"  data-regex="/clients_2018-08-01-16-32-12/" > <spam class="glyphicon glyphicon-download-alt"></spam> 6</a>)
     * set to table de file upload
     *
     * @param string $id_save
     * @return string
     */
    public function get_idfile(string $id_save): string;

    /**
     * has id return true | false
     * @param string $id
     * @return bool
     */
    public function is_id(string $id, $schema = null): bool;

    /**
     * recherche par id
     * @param type $id
     * @param array $mode
     * @param EntitysSchema $schema
     * @return EntitysDataTable
     */
    public function find_by_id($id, array $mode = self::MODE_SELECT_DEFAULT_DEFAULT, $schema = null): EntitysDataTable;

    /**
     * pour select data to table

     * @param type $id
     * @param array $mode
     * @param EntitysSchema $schema
     * @return array
     */
    public function select($id = true, array $mode = self::MODE_SELECT_DEFAULT_DEFAULT, $schema = null): array;

    /**
     * select donnee simple return array assoc
     * @param array $fields
     * @param type $id
     * @param EntitysSchema $schema
     * @return array assoc
     */
    public function select_simple(array $fields, $id = true, $schema = null): array;

    /**
     * pour sele data in range

     * @param string|array $rangeID
     * @param array $mode
     * @param EntitysSchema $schema
     * @return array EntitysDataTable
     */
    public function select_in($rangeID, array $mode = self::MODE_SELECT_DEFAULT_DEFAULT, $schema = null): array;

    /**
     * select data BETWEEN 2 value in id

     * @param int $valeur1
     * @param int $valeur2
     * @param array $mode
     * @param EntitysSchema $schema
     * @return array EntitysDataTable
     */
    public function select_BETWEEN(int $valeur1, int $valeur2, array $mode = self::MODE_SELECT_DEFAULT_DEFAULT, $schema = null): array;
}
