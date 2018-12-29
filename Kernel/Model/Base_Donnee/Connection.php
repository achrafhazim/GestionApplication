<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

use Exception;
use Kernel\AWA_Interface\Base_Donnee\ConnectionInterface;
use Kernel\File\File;
use PDO;
use TypeError;

/**
 * Description of Connection
 * snglton class
 *
 * @author wassime
 */
class Connection implements ConnectionInterface
{

    const File_Connect_DataBase = "Connect_DataBase";
    const BOOT = "BOOT";
    const cache = "cache";
    const dbname = "dbname";

    private static $fileConfigDB;
    private static $fileCashDB;
    private static $ConfigDB;
    private static $PDO = null;
    private static $DBname = "";

    /**
     * singlton
     * @param string $PathConfigJson
     * @return PDO
     */
    public static function getPDO(string $PathConfigJson, string $PathCash): PDO
    {
        if (self::$PDO === null) {
            $fileConfig = new File($PathConfigJson, File::JSON, []);
            self::setFileConfigDB($fileConfig);

            $fileCash = new File($PathCash, File::JSON, []);
            self::setFileCashDB($fileCash);

            $config = self::getFileConfigDB(self::File_Connect_DataBase, File::PHP);
            self::setConfigDB($config);
            $dsn = self::getConfigDB('dsn');
            $dbuser = self::getConfigDB('dbuser');
            $dbpass = self::getConfigDB('dbpass');
            $dbname = self::getConfigDB('dbname');
            self::$DBname = $dbname;

            try {
                self::$PDO = new PDO($dsn, $dbuser, $dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            
                self::$PDO->exec(" CREATE DATABASE IF NOT EXISTS " . $dbname);
                self::$PDO->query(" use $dbname");
            } catch (Exception $e) {
                die('Erreur data base: de config Connection   ' . $e->getMessage());
            }
        }

        return self::$PDO;
    }

    /**
     * data config file
     * @param string $key
     * @return array|string
     */
    static function getConfigDB(string $key = "")
    {
        if ($key == "") {
            return self::$ConfigDB;
        } else {
            return self::$ConfigDB[$key];
        }
    }

    /**
     *
     * @param string $PathConfigJson
     */
    public function __construct(string $PathConfigJson, string $PathCashJson, $table = null)
    {
        self::getPDO($PathConfigJson, $PathCashJson);
    }

    /**
     * singlton
     * @return PDO
     */
    public function getDatabase(): PDO
    {

        return self::$PDO;
    }

    public function getDBnames(): string
    {
        return self::$DBname;
    }

    /**
     *
     * @param string $key
     * @param string $type
     * @return type
     */
    static function getFileConfigDB(string $key = "", string $type = File::JSON)
    {

        if ($key == "") {
            return self::$fileConfigDB;
        } else {
            return self::$fileConfigDB->get($key, $type);
        }
    }

    /**
     *
     * @param string $key
     * @param string $type
     * @return type
     */
    static function getFileCashDB(string $key = "", string $type = File::JSON)
    {

        if ($key == "") {
            return self::$fileCashDB;
        } else {
            return self::$fileCashDB->get($key, $type);
        }
    }

    /**
     *
     * @param File $fileConfigDB
     */
    static function setFileConfigDB(File $fileConfigDB)
    {
        self::$fileConfigDB = $fileConfigDB;
    }

    /**
     *
     * @param File $fileCashDB
     */
    static function setFileCashDB(File $fileCashDB)
    {
        self::$fileCashDB = $fileCashDB;
    }

    /**
     *
     * @param array $config
     * @throws TypeError
     */
    static function setConfigDB(array $config)
    {
        if (empty($config)) {
            throw new TypeError(" erreur file config dataBase json or path ");
        }
        self::$ConfigDB = $config[$config[self::BOOT]];
    }
}
