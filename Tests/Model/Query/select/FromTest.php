<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QueryTest
 *
 * @author wassime
 */
use Kernel\Model\Query\QuerySQL;

class FromTest extends \PHPUnit\Framework\TestCase
{

    public function testFromsimple()
    {
        $sql = ' SELECT nom, prenom, ville, age AS `age Client`  FROM  client WHERE 1';

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->column(["age" => "age Client"])
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testFromAlias()
    {
        $sql = ' SELECT nom, prenom, ville, age AS `age Client`  FROM  client AS cl WHERE 1';

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->column(["age" => "age Client"])
                ->from("client", "cl")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
}
