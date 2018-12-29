<?php

/*
LDD : langage de< définition> des données
LDD : langage de définition des données
Colonnes
Tables
Contraintes
Tables et contraintes
 */

namespace Kernel\Model\Query;

/**
 *
 * @author Wassim Hazime
 */
interface I_QuerySQL_LDD
{
    public function select() ;

    public function from(string $table, string $alias = '') ;
    public function column();
    
//where
    public function where() ;
    public function whereIn(string $column, array $range);
    public function whereBETWEEN(string $column, $valeur1, $valeur2);
    public function whereLike(string $column, $LIKE);
    
    public function whereNot(string $column, int $value);
    public function whereNotBETWEEN(string $column, $valeur1, $valeur2);
    public function whereNotIn(string $column, array $range);
    public function whereNotLike(string $column, $LIKE);
    
    public function whereNULL(string $column);
 
    
//join
    public function join($tablejoin, string $type = "INNER", bool $relation = false, string $conditions = '') ;
    public function joinAlias(string $table, string $alias, string $conditions, $type = "INNER");
    public function independent(string $master);

   // group
    public function group($column, $direction = null);
    
   //having
//public function having($column, $value);
//public function havingIn($column, array $values);
//public function havingLike($column, $value);
//public function havingNot($column, $value);
//public function havingRaw($sql, $parameters);

    






//public function limit($limit);
//public function offset($offset);
//public function order($column, $direction = null);
//public function prependColumn($column, $alias = null);
//public function type($type);
}
