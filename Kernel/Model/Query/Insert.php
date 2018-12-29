<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Query;

/**
 * Description of Insert
 *
 * @author wassime
 */
class Insert extends Abstract_Query
{

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

            foreach ($data as $value) {
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

    //traitement

    public function query(): string
    {
        $table = implode(', ', $this->table);
        return ' INSERT INTO ' . $table . $this->value;
    }

    public function prepareQuery(): Prepare
    {

        $table = implode(', ', $this->table);
        $prepare = ' INSERT INTO ' . $table . $this->valuePrepare["sql"];
        $execute = $this->valuePrepare["value"];

        return new Prepare($prepare, $execute);
    }
}
