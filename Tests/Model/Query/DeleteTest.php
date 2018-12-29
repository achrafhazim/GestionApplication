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

class DeleteTest extends TestCase {

    public function testSimpleDelete() {
        $sql = 'DELETE FROM client WHERE ( id=2 )';
        $sqlquery = (new QuerySQL())
                ->delete("client")
                ->where("id=2")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_where_Delete() {
        $sql = 'DELETE FROM client WHERE ( id=2 )';
        $sqlquery = (new QuerySQL())
                ->delete("client")
                ->where("id=2")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSimpleDeleteArray() {
        $sql = 'DELETE FROM client WHERE ( id=2 )';
        $sqlquery = (new QuerySQL())->delete("client")
                ->where(["id=2"])
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_where_DeleteArray() {
        $sql = 'DELETE FROM client WHERE ( id=2 )';
        $sqlquery = (new QuerySQL())
                ->delete("client")
                ->where(["id=2"])
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testSimpleDeleteArrayAssoc() {
        $sql = 'DELETE FROM client WHERE ( id = 2 )';
        $sqlquery = (new QuerySQL())->delete("client")
                ->where(["id" => 2])
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_where_DeleteArrayAssoc() {
        $sql = 'DELETE FROM client WHERE ( id = 2 )';
        $sqlquery = (new QuerySQL())
                ->delete("client")
                ->where(["id" => 2])
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_vide() {
        $sql = 'DELETE FROM clients WHERE 1';
        $sqlquery = (new QuerySQL())
                ->delete("clients")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

}
