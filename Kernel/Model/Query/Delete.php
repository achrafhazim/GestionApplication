<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Query;

/**
 * Description of Delete
 *
 * @author wassime
 */
class Delete extends Abstract_Query
{

    function __construct($table)
    {
        $this->table[] = $table;
    }

    //traitement

    public function query(): string
    {
        $table = implode(', ', $this->table);
        $where = ' WHERE ' . implode(' AND ', $this->conditionsSimple);
        return 'DELETE FROM ' . $table . $where;
    }

    public function prepareQuery(): Prepare
    {
        $table = implode(', ', $this->table);
        $execute = $this->conditionsValues;
        $condition = array_merge($this->conditionsPrepares, $this->conditionsPrepares_values);
        $where = " where " . implode(' AND ', $condition);
        $prepare = 'DELETE FROM ' . $table . $where;
        return new Prepare($prepare, $execute);
    }
}
