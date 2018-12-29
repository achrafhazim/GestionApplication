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

class ColumnSelectTest extends \PHPUnit\Framework\TestCase
{

    public function testSelectColumnArrayStringAlias()
    {
        $sql = ' SELECT nom, age AS `age Client`,  adress ,  prenom as `prenom Client` ,  code , post as CodePost, ville, email  FROM  client WHERE 1';
        $sqlquery = (new QuerySQL())
                ->select("nom", ["age" => "age Client"], ["adress"], ["prenom as `prenom Client`"], ["code"], "post as CodePost")
                ->column("ville")
                ->column("email")
                ->from("client")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
}
