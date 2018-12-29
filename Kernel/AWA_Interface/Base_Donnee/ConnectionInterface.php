<?php

namespace Kernel\AWA_Interface\Base_Donnee;

use Kernel\File\File;
use PDO;
use TypeError;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author wassime
 */
interface ConnectionInterface
{

    public function __construct(string $PathConfigJson, string $PathCashJson, $table = null);

    /**
     * singlton
     * @param string $PathConfigJson
     * @return PDO
     */
    public static function getPDO(string $PathConfigJson, string $PathCash): PDO;

    /**
     * data config file
     * @param string $key
     * @return array|string
     */
    static function getConfigDB(string $key = "");

    /**
     * singlton
     * @return PDO
     */
    public function getDatabase(): PDO;

    /**
     * singlton
     * @return string
     */
    public function getDBnames(): string;

    /**
     *
     * @param string $key
     * @return type File | array
     */
    static function getFileConfigDB(string $key = "", string $type = "json");

    /**
     *
     * @param string $key
     * @return type File | array
     */
    static function getFileCashDB(string $key = "", string $type = "json");

    /**
     *
     * @param File $fileConfigDB
     */
    static function setFileConfigDB(File $fileConfigDB);

    /**
     *
     * @param File $fileCashDB
     */
    static function setFileCashDB(File $fileCashDB);

    /**
     *
     * @param array $config
     * @throws TypeError
     */
    static function setConfigDB(array $config);
}
