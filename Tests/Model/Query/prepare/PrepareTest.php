<?php

use Kernel\Model\Query\QuerySQL;
use PHPUnit\Framework\TestCase;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrepareTest
 *
 * @author wassime
 */
class PrepareTest extends TestCase {
    
    
       public function testselect() {
        $query = (new QuerySQL())
                ->select("id")
                ->column("nom","prenom")
                ->from("client")
                ->where(["id"=>3])
               ->prepareQuery();
                

        $prepare = $query->getPrepare();
        $execute = $query->getExecute();
        $this->assertEquals($prepare," SELECT id, nom, prenom  FROM  client WHERE ( id  = ? )");

        $this->assertArraySubset([3], $execute);
    }
    
      
       public function testselect_classique() {
        $query = (new QuerySQL())
                ->select("id")
                ->column("nom","prenom")
                ->from("client")
                ->where(["id"=>3])->whereNULL("age")
               ->prepareQuery();
                

        $prepare = $query->getPrepare();
        $execute = $query->getExecute();
        $this->assertEquals($prepare," SELECT id, nom, prenom  FROM  client WHERE ( id  = ? ) AND ( age IS NULL )");

        $this->assertArraySubset([3], $execute);
    }
    
    
    

    public function testInsert() {
        $query = (new QuerySQL())->insertInto("client")
                ->value(["nom" => "wassim", "age" => 20])
                ->prepareQuery();

        $prepare = $query->getPrepare();
        $execute = $query->getExecute();
        $this->assertEquals($prepare, " INSERT INTO client (`nom`, `age`) VALUES (? , ?) ");

        $this->assertArraySubset(["wassim", "20"], $execute);
    }

    public function testUpdate() {
        $query = (new QuerySQL())->update("client")
                ->value(["nom" => "wassim", "age" => 20])->where(["id" => "6"])
                ->prepareQuery();

        $prepare = $query->getPrepare();
        $execute = $query->getExecute();
        $this->assertEquals($prepare, "UPDATE  client  (`nom`, `age`) VALUES (? , ?)  WHERE ( id  = ? )");

        $this->assertArraySubset(["wassim", "20", "6"], $execute);
    }

    public function testUpdate_classique() {
        $query = (new QuerySQL())->update("client")
                ->value(["nom" => "wassim", "age" => 20])
                ->where(["id" => "6"])
                ->where("age>66")
                ->prepareQuery();

        $prepare = $query->getPrepare();
        $execute = $query->getExecute();
        $this->assertEquals($prepare, "UPDATE  client  (`nom`, `age`) VALUES (? , ?)  WHERE ( id  = ? ) AND ( age>66 )");

        $this->assertArraySubset(["wassim", "20", "6"], $execute);
    }

    public function testDelete() {
        $query = (new QuerySQL())->delete("client")->where(["id" => "2"])->prepareQuery();

        $prepare = $query->getPrepare();
        $execute = $query->getExecute();
        $this->assertEquals($prepare, "DELETE FROM client where ( id  = ? )");

        $this->assertArraySubset(["2"], $execute);
    }

    public function testDelete_classique() {
        $query = (new QuerySQL())->  delete("client")->
                where(["id" => "2"])->
                where("age>8")->
                where("t=66")->
              
                prepareQuery();

        $prepare = $query->getPrepare();
        $execute = $query->getExecute();
        $this->assertEquals($prepare, "DELETE FROM client where ( id  = ? ) AND ( age>8 ) AND ( t=66 )");

        $this->assertArraySubset(["2"], $execute);
    }

}
