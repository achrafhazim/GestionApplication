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

class ColumnTest extends \PHPUnit\Framework\TestCase
{

    public function testSelectStringSimpleColumn()
    {
        $sql = " SELECT nom , age  FROM  client WHERE 1";
        $sqlquery = (new QuerySQL())->select()
                ->column("nom , age")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectStringColumn()
    {
        $sql = " SELECT nom, age  FROM  client WHERE 1";
        $sqlquery = (new QuerySQL())->select()
                ->column("nom", "age")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectArrayColumn()
    {
        $sql = " SELECT  nom ,  age   FROM  client WHERE 1";
        $sqlquery = (new QuerySQL())->select()
                ->column(["nom", "age"])
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectArrayANDstringColumn()
    {
        $sql = " SELECT  nom ,  age , adresse  FROM  client WHERE 1";
        $sqlquery = (new QuerySQL())->select()
                ->column(["nom", "age"], "adresse")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectStringColumnAlias()
    {
        $sql = ' SELECT nom, age, adress as ADRESS  FROM  client WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->column("nom")
                ->column("age")
                ->column("adress as ADRESS")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectArrayColumnAlias()
    {
        $sql = ' SELECT nom, age AS `age Client`,  adress , date, post as CodePost  FROM  client WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->column("nom", ["age" => "age Client"], ["adress"])
                ->column("date")
                ->column("post as CodePost")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSelectArrayStringColumnAlias()
    {
        $sql = ' SELECT nom, age AS `age Client`,  adress ,  prenom as `prenom Client` ,  code , post as CodePost  FROM  client WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->column("nom", ["age" => "age Client"], ["adress"])
                ->column(["prenom as `prenom Client`"], ["code"])
                ->column("post as CodePost")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
}
