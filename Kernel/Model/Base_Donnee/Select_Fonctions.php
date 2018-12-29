<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

use Kernel\Model\Query\QuerySQL;
use Kernel\Tools\Tools;
use function var_dump;

/**
 * Description of Select_Fonctions
 *
 * @author wassime
 */
class Select_Fonctions extends Select
{
      

    /*
     * ***************************************************************
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |

     */ ///****************************************************************////

    private $schema_statistique = [];

    ////////////////////////////////////////////////////////////////////////////////



    public function chargeDataSelect()
    {
        $sh = $this->getSchemaStatistique("sum", " ");
        $dataselect = [];
        foreach ($sh as $key => $value) {
            $dataselect[] = $key;
        }
        return $dataselect;
    }

    public function statistique_global()
    {
        $sh = $this->getALLschema();
        foreach ($sh as $value) {
            $st = ($value->select_statistique_SUM());
            if (!empty($st["select"])) {
                $this->schema_statistique[$st["table"]] = ["champ" => $st["select"],
                    "par" => $st["FOREIGN_KEY"]];
            }
        }
        foreach ($this->schema_statistique as $table => $st) {
            $champ = $st["champ"];
            echo "<h1> $table </h1>";
            $sql = (self::Get_QuerySQL()
                            ->select($champ)
                            ->from($table)
                            ->where("YEAR(`date`)=2018")
                    );
            $entity = $this->query($sql);
            var_dump(Tools::entitys_TO_array($entity)[0]);
        }
    }

    public function statistique_pour(array $query)
    {
        $startdate = $query["startinputDate"];
        $findate = $query["fininputDate"];
        $tables = $query["Rapports"];
        $json = [];
        foreach ($tables as $table) {
            $json[] = $this->statistique_par($table, $startdate, $findate);
        }
        return Tools::json($json);
    }

    public function statistique_par($table, $startdate, $findat)
    {
        $schema_statistiqueMIN = $this->getSchemaStatistique("sum", "", $table);
        foreach ($schema_statistiqueMIN as $table => $st) {
            $champ = $st["filds"];
            $par = $st["GroupBy"];
            $st = [];
            foreach ($par as $by) {
                $sql = (self::Get_QuerySQL()
                                ->select($champ)
                                //  ->column("$by.$by")
                                ->from($table)
                                ->whereBETWEEN("date", Tools::date_FR_to_EN($startdate), Tools::date_FR_to_EN($findat))
                        );
                $st = $this->querySimple($sql . " GROUP BY $by ");
                // echo (Tools::json($entity));
                //return $sql . " GROUP BY $by ";
            }
            //  var_dump (($st));
            return Tools::json($st);
        }
    }

    public function total($table, $champ, $alias, $date)
    {
        $sh = $this->getALLschema();
        foreach ($sh as $value) {
            $st = ($value->select_statistique_SUM());
            if (!empty($st["select"])) {
                $this->schema_statistique[$st["table"]] = ["champ" => $st["select"],
                    "par" => $st["FOREIGN_KEY"]];
            }
        }
        var_dump($this->schema_statistique);
        $sql = "SELECT  SUM($champ) as $alias FROM $table WHERE YEAR(`date`)=$date ";
        $entity = $this->query($sql);
        return Tools::entitys_TO_array($entity);
    }

    public function totalpar($table, $champ, $alias, $date, $by)
    {
        $sql = "SELECT $by, SUM($champ) as $alias FROM $table WHERE YEAR(`date`)=$date "
                . " GROUP BY $by ";
        $entity = $this->query($sql);
        return Tools::entitys_TO_array($entity);
    }
}
