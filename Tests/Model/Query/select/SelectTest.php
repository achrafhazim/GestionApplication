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

class SelectTest extends \PHPUnit\Framework\TestCase
{
    public function testSelect()
    {
        $sql = " SELECT *  FROM  client WHERE 1";
        $sqlquery = (new QuerySQL())->select()
              ->from("client")
              ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectStringSimple()
    {
        $sql = " SELECT nom , age  FROM  client WHERE 1";
        $sqlquery = (new QuerySQL())->select("nom , age")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectString()
    {
        $sql = " SELECT nom, age  FROM  client WHERE 1";
        $sqlquery = (new QuerySQL())->select("nom", "age")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectArray()
    {
        $sql = " SELECT  nom ,  age   FROM  client WHERE 1";
        $sqlquery = (new QuerySQL())->select(["nom", "age"])
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectArrayANDstring()
    {
        $sql = " SELECT  nom ,  age , adresse  FROM  client WHERE 1";
        $sqlquery = (new QuerySQL())->select(["nom", "age"], "adresse")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectStringAlias()
    {
        $sql = ' SELECT adress as ADRESS  FROM  client WHERE 1';
        $sqlquery = (new QuerySQL())->select("adress as ADRESS")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectArrayAlias()
    {
        $sql = ' SELECT nom, age AS `age Client`,  adress , post as CodePost  FROM  client WHERE 1';
        $sqlquery = (new QuerySQL())->select("nom", ["age" => "age Client"], ["adress"], "post as CodePost")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectArrayStringAlias()
    {
        $sql = ' SELECT nom, age AS `age Client`,  adress ,  prenom as `prenom Client` ,  code , post as CodePost  FROM  client WHERE 1';
        $sqlquery = (new QuerySQL())->select("nom", ["age" => "age Client"], ["adress"], ["prenom as `prenom Client`"], ["code"], "post as CodePost")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
}
