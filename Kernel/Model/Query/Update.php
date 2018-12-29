<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Query;

/**
 * Description of Update
 *
 * @author wassime
 */
class Update extends Abstract_Query
{

//update
    function __construct(string $table)
    {


        $this->table[] = $table;
    }

    public function value(array $data)
    {

        if ($this->isAssoc($data)) {
            // sql simple
            $this->value = " (`" . implode("`, `", array_keys($data)) . "`)" .
                    " VALUES ('" . implode("', '", $data) . "') ";



            // sql prepare
            $valuep = [];
            $sqlp = [];

            foreach ($data as $key => $value) {
                $sqlp[] = "?";
                $valuep[] = $value;
            }

            $this->valuePrepare["sql"] = " (`" . implode("`, `", array_keys($data)) . "`)" .
                    " VALUES (" . implode(" , ", $sqlp) . ") ";
            $this->valuePrepare["value"] = $valuep;

            return $this;
        }
        return "error value insert querysql";
    }

    public function set(array $data)
    {

        $l = "";
        foreach ($data as $x => $x_value) {
            if ($l == "") {
                $l = '  `' . $x . '`' . '=' . '\'' . $x_value . '\'  ';
            } else {
                $l .= " , " . '`' . $x . '`' . '=' . '\'' . $x_value . '\'  ';
            }
        }
        $this->value = " SET " . $l;



        // sql prepare
        $valuep = [];
        $sqlp = "";

        foreach ($data as $key => $value) {
            if ($sqlp == "") {
                $sqlp = '  `' . $key . '`' . '= ? ';
            } else {
                $sqlp .= " , " . '`' . $key . '`' . '= ? ';
            }

            $valuep[] = $value;
        }

        $this->valuePrepare["sql"] = " SET " . $sqlp;
        $this->valuePrepare["value"] = $valuep;



        return $this;
    }

    //traitement

    public function query(): string
    {
        $table = implode(', ', $this->table);

        $where = ' WHERE ' . implode(' AND ', $this->conditionsSimple);

        $action = 'UPDATE  ';
        $set = " " . $this->value;
        return $action . $table . $set . $where;
    }

    public function prepareQuery(): Prepare
    {

        $table = implode(', ', $this->table);
        $condition = array_merge($this->conditionsPrepares, $this->conditionsPrepares_values);
        $where = " WHERE " . implode(' AND ', $condition);
        $set = " " . $this->valuePrepare["sql"];
        $prepare = "UPDATE  " . $table . $set . $where;
        $conditonsprepare = $this->conditionsValues;
        $execute = array_merge($this->valuePrepare["value"], $conditonsprepare);

        return new Prepare($prepare, $execute);
    }
}
