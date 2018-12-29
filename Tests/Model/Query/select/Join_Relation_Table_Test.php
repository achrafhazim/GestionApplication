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

class Join_Relation_Table_Test extends \PHPUnit\Framework\TestCase
{

//table relation simple =>Relation_Table
    public function test_Simple_Join()
    {
        // table relation simple =>Relation_Table
        $sql = ' SELECT *  FROM  bl  '
                . 'INNER JOIN r_bl_commande '
                . '     ON bl.id =r_bl_commande.id_bl'
                . ' INNER JOIN commande'
                . '   ON commande.id =r_bl_commande.id_commande'
                . ' WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->from("bl")
                ->join("commande", "INNER", true)
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_Simple_Join_column_name()
    {
        // table relation simple  =>Relation_Table
        $sql = ' SELECT N, la_somme, tarif_estime '
                . ' FROM  bl '
                . ' INNER JOIN r_bl_commande '
                . '     ON bl.id =r_bl_commande.id_bl'
                . ' INNER JOIN commande'
                . '   ON commande.id =r_bl_commande.id_commande'
                . ' WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->column("N")
                ->column("la_somme")
                ->column("tarif_estime")
                 ->from("bl")
                ->join("commande", "INNER", true)
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_Simple_Join_select_name()
    {
        // table relation simple  =>Relation_Table
        $sql = ' SELECT bl.N, la_somme, tarif_estime '
                . ' FROM  bl  '
                . 'INNER JOIN r_bl_commande '
                . '     ON bl.id =r_bl_commande.id_bl'
                . ' INNER JOIN commande'
                . '   ON commande.id =r_bl_commande.id_commande'
                . ' WHERE 1';
        $sqlquery = (new QuerySQL())->select("bl.N", "la_somme", "tarif_estime")
                ->from("bl")
                ->join("commande", "INNER", true)
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
    ///////////////////////////////////////////////////////

    public function test_plusierTables_string_Join()
    {
        //table relation simple =>FOREIGN_KEY
        // table relation simple =>Relation_Table
        $sql = ' SELECT *  FROM  bl'
                . ' INNER JOIN raison_sociale'
                . ' ON  raison_sociale.id  = bl.raison_sociale'
                . '    INNER JOIN r_bl_commande'
                . '      ON bl.id =r_bl_commande.id_bl'
                . ' INNER JOIN commande'
                . '   ON commande.id =r_bl_commande.id_commande'
                . ' WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->from("bl")
                ->join("raison_sociale")
                ->join("commande", "INNER", true)
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }

    public function test_plusierTables_array_Join()
    {
        //table relation simple =>FOREIGN_KEY
        // table relation simple =>Relation_Table
        $sql = ' SELECT *  FROM  paiement'
                
                . ' INNER JOIN raison_sociale'
                . ' ON  raison_sociale.id  = paiement.raison_sociale'
                
                . '   INNER JOIN mode_paiement'
                . ' ON  mode_paiement.id  = paiement.mode_paiement'
                
                . '    INNER JOIN r_paiement_facture'
                . '      ON paiement.id =r_paiement_facture.id_paiement'
                . ' INNER JOIN facture'
                . '   ON facture.id =r_paiement_facture.id_facture'
                
                    
                . '    INNER JOIN r_paiement_avoir'
                . '      ON paiement.id =r_paiement_avoir.id_paiement'
                . ' INNER JOIN avoir'
                . '   ON avoir.id =r_paiement_avoir.id_avoir'
                
                    
                . ' WHERE 1';
        $sqlquery = (new QuerySQL())->select()
                ->from("paiement")
                ->join(["raison_sociale", "mode_paiement"])
                ->join("facture", "INNER", true)
                ->join("avoir", "INNER", true)
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
    ///////////////////////////////////////////////////////


    public function test_Simple_independent()
    {
         $sql = ' SELECT *  FROM  commande '
                 . 'LEFT JOIN   r_bl_commande'
                 . ' ON  r_bl_commande.id_commande =commande.id'
                 . ' WHERE (   r_bl_commande.id_commande IS NULL )';
        $sqlquery = (new QuerySQL())->select()
                ->from("commande")
                ->independent("bl")
                ->query();
        $this->assertEquals($sql, $sqlquery);
    }
}
