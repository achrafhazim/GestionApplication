<?php

use PHPUnit\Framework\TestCase;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of DeleteTest
 *
 * @author wassime
 */
use Kernel\Model\Query\QuerySQL;

class InsertTest extends TestCase
{

    public function testSimpleDelete()
    {
        $sql = " INSERT INTO bl (`name`, `age`)"
                . " VALUES ('achraf', '44') ";
        $sqlquery = (new QuerySQL())
                ->insertInto('bl')
                ->value(["name"=>"achraf","age"=>44])
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
}
