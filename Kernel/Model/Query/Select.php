<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Query;

/**
 * Description of Select
 *
 * @author wassime
 */
class Select extends Abstract_Query
{

    protected $column = ["*"];
    protected $join = [];

    function __construct()
    {
        /// select query
        //(new QuerySQL())->
        // ->select("nom,age,adress as ADRESS ") or
        // ->select("nom) ->select("age") ->select("adress as ADRESS") or
        // ->select("nom","age","adress") or
        // ->select(["nom","age","adress"])or
        // ->select(["nom","age"],["adress"],"prenom")
        //**** alias
        //->select("nom",["age"=>"age Client"],["adress"])
        //->select("nom",["age as `age Client`"],["adress"])


        if (isset(func_get_args()[0])) {
            $this->setColumn(func_get_args()[0]);
        }
    }

    protected function setColumn(array $columns)
    {
        if ($columns != null or ! empty($columns)) {
            if ($this->column[0] == "*") {
                $this->column = [];
            }

            foreach ($columns as $args) {
                if (is_array($args)) {
                    if ($this->isAssoc($args)) {
                        foreach ($args as $column => $alias) {
                            $this->column[] = "$column AS `$alias`";
                        }
                    } else {
                        foreach ($args as $column) {
                            $this->column[] = " $column ";
                        }
                    }
                } else {
                    $this->column[] = $args;
                }
            }
        }
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function column()
    {

        /// column query
        //(new QuerySQL())->select()->
        // ->column("nom,age,adress") or
        // ->column("nom")->column("age")->column("adress as ADRESS") or
        // ->column("nom","age","adress") or
        // ->column(["nom","age","adress"])or
        // ->column(["nom","age"],["adress"],"prenom")
        //**** alias
        //->column("nom",["age"=>"age Client"],["adress"])
        //->column("nom",["age as `age Client`"],["adress"])
        $this->setColumn(func_get_args());
        return $this;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function from(string $table, string $alias = '')
    {
        /// form query
        //from("client_table")->from("adress_table")
        //**** alias
        //from("client_table","client")

        if ($alias == '') {
            $this->table[] = $table;
        } else {
            $this->table[] = "$table AS $alias";
        }
        return $this;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////



    public function whereBETWEEN(string $column, $valeur1, $valeur2)
    {
        //query BETWEEN
        //L’intervalle peut être constitué de chaînes de caractères, de nombres ou de dates
        //new QuerySQL())->select()
        //                  ->from('test')
        //                  ->whereBETWEEN("id", 6, 10)
        //SELECT *  FROM  test WHERE ( id BETWEEN '6' AND '10' )
        //
        
        $this->where("$column BETWEEN '$valeur1' AND '$valeur2'");
        return $this;
    }

    public function whereIn(string $column, array $range)
    {
        //query IN
        //
        //(new QuerySQL())->select()
        //  ->from("test")
        // ->whereIn("id", [37,38,48])
        //SELECT *  FROM  test WHERE ( id IN  ( 37 , 38 , 48 )  )
        $range = ' ( ' . implode(' , ', $range) . ' )';

        $this->where("$column IN $range ");
        return $this;
    }

    public function whereLike(string $column, $LIKE)
    {
        //query Like
        //Ce mot-clé permet d’effectuer une recherche sur un modèle
        //particulier. Il est par exemple possible de rechercher les
        //enregistrements dont la valeur d’une colonne commence par
        // telle ou telle lettre. Les modèles de recherches sont multiple.
        //
        //(new QuerySQL())->select()
        //               ->from('test')
        //               ->whereLike("id",["3%","4%"] )
        //              ->whereLike("nom",["a%","A%"] )
        //              ->whereLike("age","2_" )
        //SELECT *  FROM  test WHERE (
        // ( `id`  LIKE '3%'  )         OR ( `id`  LIKE '4%'  )  )
        // AND ( ( `nom`  LIKE 'a%'  )  OR ( `nom`  LIKE 'A%'  )  )
        //  AND ( age Like '2_'  )

        if (is_array($LIKE)) {
            $liks = [];
            foreach ($LIKE as $link) {
                $liks[] = "( `$column`  LIKE '$link'  ) ";
            }



            $this->where(implode(' OR ', $liks));
        } else {
            $this->where("$column Like '$LIKE' ");
        }
        return $this;
    }

    public function whereNot(string $column, int $value)
    {
        // qury not
        //
        //new QuerySQL())->
        // select()->from('test')
        //->whereNot("age","20" )
        //SELECT *  FROM  test WHERE ( age != 20  )
        //
        $this->where("$column != $value ");
        return $this;
    }

    public function whereNotIn(string $column, array $range)
    {
        //query IN
        //
        //(new QuerySQL())->select()
        //  ->from("test")
        // ->whereNotIn("id", [37,38,48])
        //SELECT *  FROM  test WHERE ( id NOT IN  ( 37 , 38 , 48 )  )
        $range = ' ( ' . implode(' , ', $range) . ' )';

        $this->where("$column NOT IN $range ");
        return $this;
    }

    public function whereNotBETWEEN(string $column, $valeur1, $valeur2)
    {
        // query notbetwen inverst betwin

        $this->where("$column NOT BETWEEN '$valeur1' AND '$valeur2'");
        return $this;
    }

    public function whereNotLike(string $column, $LIKE)
    {
        //query Like
        //Ce mot-clé permet d’effectuer une recherche sur un modèle
        //particulier. Il est par exemple possible de rechercher les
        //enregistrements dont la valeur d’une colonne commence par
        // telle ou telle lettre. Les modèles de recherches sont multiple.
        //
        //(new QuerySQL())->select()
        //               ->from('test')
        //               ->whereNotLike("id",["3%","4%"] )
        //              ->whereNotLike("nom",["a%","A%"] )
        //              ->whereNotLike("age","2_" )
        //SELECT *  FROM  test WHERE (
        // ( `id`  NOT LIKE '3%'  )         OR ( `id`  NOT LIKE '4%'  )  )
        // AND ( ( `nom`  NOT LIKE 'a%'  )  OR ( `nom`  NOT LIKE 'A%'  )  )
        //  AND ( age NOT Like '2_'  )

        if (is_array($LIKE)) {
            $liks = [];
            foreach ($LIKE as $link) {
                $liks[] = "( `$column` NOT LIKE '$link'  ) ";
            }



            $this->where(implode(' OR ', $liks));
        } else {
            $this->where("$column NOT Like '$LIKE' ");
        }
        return $this;
    }

    public function whereNULL(string $column)
    {
        // is null
        $this->where("$column IS NULL");
        return $this;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////
    protected function joinstring($tablejoin, string $type = "INNER", bool $relation = false, string $conditions = '', string $TABLEpere = "")
    {



//
//( new QuerySQL())->select()
        // ->from('produit')
        // ->join("categorie")
//SELECT *  FROM  produit INNER JOIN categorie ON id_categorie  = categorie_produit
//or
//select()
        // ->from('produit')
        // ->join("categorie","INNER",FALSE,"id_categorie=pro_categorie")
//    SELECT *  FROM  produit INNER JOIN categorie ON  id_categorie=pro_categorie
//or
//                      select() ->from('produit')
        //->join("categorie","INNER",true)
//
//SELECT *  FROM  produit
// INNER JOIN d_produit_categorie ON id_produit=id_produit_detail
// INNER JOIN categorie           ON id_categorie=id_categorie_detail
//
       
        if ($TABLEpere=="") {
            $TABLEpere = $this->table[0];
        }


        if ($relation) {
            $TABLEenfant = $tablejoin;
            $RD = 'r_' . $TABLEpere . '_' . $TABLEenfant;


            //LEFT JOIN d_facture_bl     ON id_facture              =id_facture_detail
            $this->join[] = "  $type JOIN $RD      ON $TABLEpere.id =$RD.id_" . $TABLEpere
                    // LEFT      JOIN  bl             on id_bl                        =id_bl_detail
                    . " $type JOIN $TABLEenfant   ON $TABLEenfant.id =$RD.id_" . $TABLEenfant;
        } else {
            //INNER JOIN raison_sociale ON id_raison_sociale = raison_sociale_facture
            if ($conditions == '') {
                $this->join[] = " $type JOIN $tablejoin ON  $tablejoin.id  = $TABLEpere.$tablejoin";
            } else {
                $join = " $type JOIN $tablejoin ON  " . $conditions;

                $this->join[] = $join;
            }
        }
    }

    public function join($tablejoin, string $type = "INNER", bool $relation = false, string $conditions = '', string $TABLEpere = "")
    {



        if (is_array($tablejoin)) {
            if ($this->isAssoc($tablejoin)) {
                foreach ($tablejoin as $tableJ => $colums) {
                    $this->joinstring($tableJ, $type, $relation, $conditions, $TABLEpere);
                }
            } else {
                foreach ($tablejoin as $tableJ) {
                    $this->joinstring($tableJ, $type, $relation, $conditions, $TABLEpere);
                }
            }
        } else {
            $this->joinstring($tablejoin, $type, $relation, $conditions, $TABLEpere);
        }

        return $this;
    }

    public function joinAlias(string $tablejoin, string $alias, string $conditions, $type = "INNER")
    {

        //select()
        // ->from('produit')
        // ->joinAlias("Categorie","c","c.id_categorie=pro_categorie")
        //
        //SELECT *  FROM  produit INNER JOIN Categorie AS c ON  c.id_categorie=pro_categorie
        //
        $join = " $type JOIN $tablejoin AS $alias ON  "
                . $conditions;

        $this->join[] = $join;

        return $this;
    }

    public function independent(string $master)
    {
        //
        //select()
        //        ->from('produit')
        //        ->independent("categorie")
        //SELECT *  FROM  produit
        //LEFT JOIN d_categorie_produit ON id_produit_detail =id_produit
        //WHERE (  id_produit_detail IS NULL )
        //
        
        $TABLE = $this->table[0];

        $RD = ' r_' . $master . '_' . $TABLE;
        //LEFT JOIN d_facture_bl ON id_bl_detail =id_bl
        $this->join[] = " LEFT JOIN  $RD ON $RD.id_" . $TABLE . " =$TABLE.id";
        // WHERE id_bl_detail IS NULL
        $this->where(" $RD.id_" . $TABLE . " IS NULL");
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    //traitement

    public function query(): string
    {
        $table = implode(', ', $this->table);
        $join = implode('  ', $this->join);
        $where = ' WHERE ' . implode(' AND ', $this->conditionsSimple);

        $action = ' SELECT ' . implode(', ', $this->column) . "  FROM  ";

        return $action . $table . $join . $where;
    }

    public function prepareQuery(): Prepare
    {
        $table = implode(', ', $this->table);
        $join = implode('  ', $this->join);
        $condition = array_merge($this->conditionsPrepares, $this->conditionsPrepares_values);
        $where = " WHERE " . implode(' AND ', $condition);
        $action = ' SELECT ' . implode(', ', $this->column) . "  FROM  ";
        $prepare = $action . $table . $join . $where;
        $execute = $this->conditionsValues;
        return new Prepare($prepare, $execute);
    }
}
