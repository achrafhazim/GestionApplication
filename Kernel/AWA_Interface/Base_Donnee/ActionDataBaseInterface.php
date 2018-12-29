<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\AWA_Interface\Base_Donnee;

use Kernel\Model\Query\Prepare;
use Kernel\Model\Query\QuerySQL;

/**
 *
 * @author wassime
 */
interface ActionDataBaseInterface
{
     /**
     *  Créons un Query Builder
     * @return QuerySQL
     */
    public static function Get_QuerySQL(): QuerySQL ;
 

    /**
     * get Shema form EntitysSchema
     * array de EntitysSchema
     * @param string $sql
     * @return array
     */
    public function querySchema(string $sql): array;

    /**
     * get data form EntitysDataTable
     * @param string $sql
     * @return array EntitysDataTable
     */
    public function query(string $sql): array;

    /**
     * // get data form EntitysDataTable avec style prepare
     * @param Prepare $query
     * @return array EntitysDataTable
     */
    public function prepareQuery(Prepare $query): array;

      /**
     * // get data form array assoc avec style prepare
     * @param Prepare $query
     * @return array Assoc
     */
    public function prepareQueryAssoc(Prepare $query): array;

    /**
     * / get data form array assoc
     * @param string $sql
     * @return array assoc
     */
    public function querySimple(string $sql): array;

    /**
     * sql simple
     * @param string $sql
     * @return int
     */
    public function exec(string $sql): int;

    /**
     *
     * @param Prepare $query
     * @return int
     */
    public function prepareEXEC(Prepare $query): int;
}
