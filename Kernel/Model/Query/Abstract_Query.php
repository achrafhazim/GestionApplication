<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Query;

use Kernel\Tools\Tools;

/**
 * Description of abstract_Query
 *
 * @author wassime
 */
abstract class Abstract_Query
{

    
    protected $table = [];
    //where  == SIMPLE
    protected $conditionsSimple = ["1"];
    //where  == PREPARE
    protected $conditionsPrepares = [];
    protected $conditionsPrepares_values = ["1"];
    protected $conditionsValues = [];
    /// inset and update
    protected $value;
    protected $valuePrepare = ["sql" => "", "value" => ""];

/////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function where()
    {
        /// query where
//
//select()
//                        ->from("test")
//                        ->where(["id_mode_paiement"=>"38"])
//                        ->where("id=5")
//                        ->where("nom=achraf","age=26")
//                        ->where(["ville=bm","d=12/6/9"],"jour=77")
//                        ->where(["client"=>"c66"])
//
// SELECT *  FROM  test
// WHERE ( id_mode_paiement = 38 )
// AND ( id=5 )
// AND ( nom=achraf ) AND ( age=26 )
// AND ( ville=bm ) AND ( d=12/6/9 ) AND ( jour=77 )
// AND ( client = c66 )
//
//

        foreach (func_get_args() as $args) {
            /// vide condition instial
            if ($this->conditionsSimple == ["1"]) {
                $this->conditionsSimple = [];
                $this->conditionsPrepares_values = [];
            }
            $this->setConditionWhere($args);
        }
        return $this;
    }

    private function setConditionWhere($args)
    {

        if (is_array($args) && $this->isAssoc($args)) {
            // ->where([id=>44])
            foreach ($args as $column => $value) {
                $this->conditionsSimple[] = "( $column = $value )";
                $this->conditionsValues[] = $value;
                $this->conditionsPrepares[] = "( $column  = ? )";
            }
        } elseif (is_array($args) && !$this->isAssoc($args)) {
            // ->where(["id>7","nom!=wassim"])
            foreach ($args as $arg) {
                $this->conditionsSimple[] = "( $arg )";
                $this->conditionsPrepares_values[] = "( $arg )";
            }
        } elseif (is_string($args) || is_bool($args)) {
            // ->where("id=33") || ->where(true)
            $this->conditionsSimple[] = "( $args )";
            $this->conditionsPrepares_values[] = "( $args )";
        }
    }

    ////////////////////////////////////////////////////////////////////
    //traitement

    abstract public function query(): string;

    abstract public function prepareQuery(): Prepare;

//    public function __toString() {
//        return $this->query();
//    }
    //// outils
    protected function isAssoc(array $arr): bool
    {
        return Tools::isAssoc($arr);
    }
}
