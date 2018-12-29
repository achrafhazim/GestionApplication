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

class WhereTest extends \PHPUnit\Framework\TestCase
{
   public function testWheresimplevide()
    {
        $sql = ' SELECT nom, prenom, ville, age AS `age Client`  FROM  client WHERE 1';

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->column(["age" => "age Client"])
                ->from("client")
                ->where()
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
///test simple where
    public function testWheresimple()
    {
        $sql = ' SELECT nom, prenom, ville, age AS `age Client`  FROM  client WHERE ( id=5 )';

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->column(["age" => "age Client"])
                ->from("client")
                ->where("id=5")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testWhereArray()
    {
        $sql = ' SELECT nom, prenom, ville  FROM  client WHERE ( id = 5 ) AND ( nom = achraf )';

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->from("client")
                ->where(["id" => "5"], ["nom" => "achraf"])
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testWhereString()
    {
        $sql = ' SELECT nom, prenom, ville  FROM  client WHERE ( id>5 ) AND ( nom=achraf )';

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->from("client")
                ->where("id>5", "nom=achraf")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testWhereStringArray()
    {
        $sql = ' SELECT nom, prenom, ville  FROM  client WHERE ( id>5 ) AND ( nom = achraf ) AND ( prenom = hazime )';

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->from("client")
                ->where("id>5", ["nom" => "achraf", "prenom" => "hazime"])
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    ///between

    public function testsimpleBtween()
    {
        $sql = " SELECT nom, prenom, ville  FROM  client WHERE ( id BETWEEN '55' AND '99' )";

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->from("client")
                ->whereBETWEEN("id", 55, 99)
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testsimpleBtweenANDwhere()
    {
        $sql = " SELECT nom, prenom, ville  FROM  client WHERE ( id BETWEEN '55' AND '99' ) AND ( nom=achraf )";

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->from("client")
                ->whereBETWEEN("id", 55, 99)
                ->where("nom=achraf")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    // IN
    public function testsimpleIN()
    {
        $sql = " SELECT nom, prenom, ville  FROM  client WHERE ( id IN  ( 1 , 8 , 7 , 9 )  )";

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->from("client")
                ->whereIn("id", [1, 8, 7, 9])
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testsimple_IN_AND_where()
    {
        $sql = " SELECT nom, prenom, ville  FROM  client WHERE ( id IN  ( 1 , 8 , 7 , 9 )  ) AND ( nom=achraf )";

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->from("client")
                ->whereIn("id", [1, 8, 7, 9])
                ->where("nom=achraf")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testsimple_IN_AND_BETWEEN_where()
    {
        $sql = " SELECT nom, age  FROM  client"
                . " WHERE ( id IN  ( 1 , 8 , 7 , 9 )  ) AND ( age BETWEEN '20' AND '50' ) AND ( nom=achraf )";

        $sqlquery = (new QuerySQL())->select("nom", "age")
                ->from("client")
                ->whereIn("id", [1, 8, 7, 9])
                ->whereBETWEEN("age", 20, 50)
                ->where("nom=achraf")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    //Like
    public function testsimpleLINK()
    {
        $sql = " SELECT nom, prenom, age  FROM  "
                . "client WHERE"
                . " ( ( `id`  LIKE '3%'  )  OR ( `id`  LIKE '4%'  )  )"
                . " AND ( ( `nom`  LIKE 'a%'  )  OR ( `nom`  LIKE 'A%'  )  )"
                . " AND ( prenom Like 'a%_f'  ) "
                . "AND ( age Like '2_'  )";

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("age")
                ->from("client")
                ->whereLike("id", ["3%", "4%"])
                ->whereLike("nom", ["a%", "A%"])
                ->whereLike("prenom", "a%_f")
                ->whereLike("age", "2_")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testsimple_LINK_AND_where()
    {
        $sql = " SELECT nom, prenom, ville  FROM  client "
                . "WHERE ( age Like '2_'  ) AND ( nom=achraf )";

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->from("client")
                ->whereLike("age", "2_")
                ->where("nom=achraf")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function testsimple_LINK_IN_AND_BETWEEN_where()
    {
        $sql = " SELECT nom, age  FROM  client"
                . " WHERE ( id IN  ( 1 , 8 , 7 , 9 )  ) AND"
                . " ( age BETWEEN '20' AND '50' ) AND"
                . " ( age Like '2_'  ) AND"
                . " ( nom=achraf )";

        $sqlquery = (new QuerySQL())->select("nom", "age")
                ->from("client")
                ->whereIn("id", [1, 8, 7, 9])
                ->whereBETWEEN("age", 20, 50)
                ->whereLike("age", "2_")
                ->where("nom=achraf")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    //not
    public function testsimple_NOT_LINK_IN_AND_BETWEEN_where()
    {
        $sql = " SELECT N, remarque  FROM  bl WHERE "
                . "( id NOT IN  ( 11 , 81 , 71 , 91 )  ) AND "
                . "( id NOT BETWEEN '40' AND '50' ) AND "
                . "( id NOT Like '11_'  ) AND "
                . "( la_somme != 0  )";

        $sqlquery = (new QuerySQL())->select("N", "remarque")
                ->from("bl")
                ->whereNotIn("id", [11, 81, 71, 91])
                ->whereNotBETWEEN("id", 40, 50)
                ->whereNotLike("id", "11_")
                ->whereNot("la_somme", 00)
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    //null
    public function testsimple_NULL_where()
    {
        $sql = " SELECT nom, prenom, ville  FROM  client WHERE"
                . " ( ville IS NULL ) AND"
                . " ( nom=achraf )";

        $sqlquery = (new QuerySQL())->select("nom", "prenom")
                ->column("ville")
                ->from("client")
                ->whereNULL("ville")
                ->where("nom=achraf")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
}
