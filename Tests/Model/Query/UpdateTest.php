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

class UpdateTest extends TestCase
{

    public function testSimpleDelete()
    {
        $sql = "UPDATE  bl  SET   `name`='achraf'   , `age`='44' "
                . "  WHERE ( id=5 )";
        $sqlquery = (new QuerySQL())
                ->update('bl')
                ->set(["name"=>"achraf","age"=>44])
                ->where("id=5")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
}
