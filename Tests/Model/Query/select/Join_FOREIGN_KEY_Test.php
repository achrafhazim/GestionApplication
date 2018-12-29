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

class Join_FOREIGN_KEY_Test extends \PHPUnit\Framework\TestCase
{

//table relation simple =>FOREIGN_KEY
    public function test_Simple_Join()
    {
        // table relation simple =>FOREIGN_KEY
        $sql = ' SELECT *  FROM '
                . ' bl INNER JOIN '
                . 'raison_sociale ON '
                . ' raison_sociale.id  = bl.raison_sociale WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->from("bl")
                ->join("raison_sociale")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_Simple_Join_column_name()
    {
        // table relation simple  =>FOREIGN_KEY
        $sql = ' SELECT N, la_somme, ICE  FROM '
                . ' bl '
                . 'INNER JOIN raison_sociale ON'
                . '  raison_sociale.id  = bl.raison_sociale WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->column("N")
                ->column("la_somme")
                ->column("ICE")
                ->from("bl")
                ->join("raison_sociale")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_Simple_Join_select_name()
    {
        // table relation simple  =>FOREIGN_KEY
        $sql = ' SELECT bl.N, la_somme, raison_sociale.ICE  '
                . 'FROM  bl INNER JOIN raison_sociale '
                . 'ON  raison_sociale.id  = bl.raison_sociale '
                . 'WHERE 1';
        $sqlquery = (new QuerySQL())->select("bl.N", "la_somme", "raison_sociale.ICE")
                ->from("bl")
                ->join("raison_sociale")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    ///////////////////////////////////////////////////////

    public function test_plusierTables_string_Join()
    {
        // table relation simple =>FOREIGN_KEY
        $sql = ' SELECT *  FROM  paiement '
                . 'INNER JOIN raison_sociale '
                . 'ON  raison_sociale.id  = paiement.raison_sociale  '
                . ' INNER JOIN mode_paiement '
                . 'ON  mode_paiement.id  = paiement.mode_paiement'
                . ' WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->from("paiement")
                ->join("raison_sociale")
                ->join("mode_paiement")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_plusierTables_array_Join()
    {
        // table relation simple =>FOREIGN_KEY
        $sql = ' SELECT *  FROM  paiement '
                . 'INNER JOIN raison_sociale '
                . 'ON  raison_sociale.id  = paiement.raison_sociale  '
                . ' INNER JOIN mode_paiement '
                . 'ON  mode_paiement.id  = paiement.mode_paiement'
                . ' WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->from("paiement")
                ->join(["raison_sociale", "mode_paiement"])
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    ///////////////////////////////////////////////////////


    public function test_Simple_joinAlias()
    {
        $sql = ' SELECT *  FROM  bl'
                . ' INNER JOIN raison_sociale AS R'
                . ' ON  R.id=bl.raison_sociale WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->from("bl")
                ->joinAlias("raison_sociale", "R", "R.id=bl.raison_sociale")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_Simple_joinAlias_condition()
    {
        //param1 table1er
        //param2 alias  table1er
        //param3 condition
        //param4 [type] optionel
        $sql = ' SELECT *  FROM  bl'
                . ' INNER JOIN raison_sociale AS R'
                . ' ON  R.id=bl.raison_sociale WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->from("bl")
                ->joinAlias("raison_sociale", "R", "R.id=bl.raison_sociale")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_FormAlias_joinAlias_condition()
    {
        //param1 table1er
        //param2 alias  table1er
        //param3 condition
        //param4 [type] optionel
        $sql = ' SELECT *  FROM  paiement AS P '
                . 'INNER JOIN mode_paiement AS M '
                . 'ON  M.id=P.mode_paiement WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->from("paiement", "P")
                ->joinAlias("mode_paiement", "M", "M.id=P.mode_paiement")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
}
