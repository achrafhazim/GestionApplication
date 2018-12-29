<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Conevert;

use Kernel\AWA_Interface\SQL_HTMLInterface;
use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Db\Table;
use Phinx\Db\Table\Column;

/**
 * Conevert  HTML Phinx
 *
 * @author wassime
 */
class HTML_Phinx implements SQL_HTMLInterface
{

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function tel(string $name = "TEL"): Column
    {
        return self::parseColumn($name, "tel");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function email(string $name = "email"): Column
    {
        return self::parseColumn($name, "email");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function email_master(string $name = "email"): Column
    {
        return self::parseColumn($name, "email_master");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function text_master(string $name): Column
    {
        return self::parseColumn($name, "text_master");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function password(string $name = "password"): Column
    {
        return self::parseColumn($name, "password");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function text(string $name): Column
    {
        return self::parseColumn($name, "text");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function file(string $name = "fichiers"): Column
    {
        return self::parseColumn($name, "file");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function textarea(string $name): Column
    {
        return self::parseColumn($name, "textarea");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function date(string $name = "date"): Column
    {
        return self::parseColumn($name, "date");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function checkBox(string $name): Column
    {
        return self::parseColumn($name, "checkBox");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function number(string $name): Column
    {
        return self::parseColumn($name, "number");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function select(string $name): Column
    {
        return self::parseColumn($name, "select");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function id(string $name = "id"): Column
    {
        return self::parseColumn($name, "id");
    }

    /**
     *
     * @param string $name
     * @return Column
     */
    public static function datetime(string $name): Column
    {
        return self::parseColumn($name, "add_update");
    }

    /**
     *
     * @return array
     */
    public static function id_default(): array
    {

        return ['id' => false, 'primary_key' => ['id']];
    }

    /**
     *
     * @param string $name
     * @param string $index
     * @return Column
     */
    private static function parseColumn(string $name, string $index): Column
    {
        $column = new Column();
        return $column->setName($name)
                        ->setType(self::HTML_SQL[$index]["typePhinix"])
                        ->setOptions(self::HTML_SQL[$index]["options"]);
    }

    /*
     *
     */



    /*     * *********************** */


    /*
     * exemple
      --
      -- Structure de la table `r_factures$ventes_devis`
      --

      CREATE TABLE `r_factures$ventes_devis` (
      `id_factures$ventes` int(11) NOT NULL,
      `id_devis` int(11) NOT NULL,
      `remarque` text DEFAULT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
     */

    public static function relation(string $pere, string $enfant, AdapterInterface $adapter)
    {
        $table = new Table('r_' . $pere . '_' . $enfant, ['id' => false, 'primary_key' => ['id_' . $pere, 'id_' . $enfant]], $adapter);
        $table->addColumn('id_' . $pere, 'integer', ['limit' => 10])
                ->addColumn('id_' . $enfant, 'integer', ['limit' => 10])
                ->addForeignKey('id_' . $pere, $pere, 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->addForeignKey('id_' . $enfant, $enfant, 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();
    }
}
