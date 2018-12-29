<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\AWA_Interface\Base_Donnee;

use Kernel\Model\Entitys\EntitysSchema;
use TypeError;

/**
 *
 * @author wassime
 */
interface MetaDatabaseInterface
{

    /**
     * is not table to data base
     * @return bool
     */
    public function is_null(): bool;

    /**
     * has in table to data base
     * @param string $nameTable
     * @return bool
     */
    public function is_Table(string $nameTable): bool;

    /**
     * has in table to data base
     * @param string $nameTable
     * @return bool
     */
    public function has_Table(string $nameTable): bool;

    /**
     * get name table set connect
     * @return string
     * @throws TypeError
     */
    public function getTable(): string;

    /**
     * set name table connect
     * @param string $table
     * @return bool
     */
    public function setTable(string $table): bool;

    /**
     * get EntitysSchema de  table par name table
     * @param string|"" $NameTable
     * @return EntitysSchema
     * @throws TypeError
     */
    public function getschema(string $NameTable = ""): EntitysSchema;

    /**
     * get tous les names tables  data base
     * @return array string
     */
    public function getAllTables(): array;

    /**
     * get tous les schemas tables  data base
     * @return array
     * @throws TypeError
     */
    public function getALLschema(): array;

    /**
     * getSchemaStatistique
     * @param type $fonction
     * @param type $alias
     * @param type $table
     * @return type
     */
    public function getSchemaStatistique($fonction, $alias, $table = "");
}
