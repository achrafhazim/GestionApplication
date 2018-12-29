<?php

use Kernel\AWA_Interface\Base_Donnee\MODE_SELECT_Interface;

/**
 * select table auto avec trois mode
 */
$select_native_table = [
    //COLUMNS_default
    MODE_SELECT_Interface::_DEFAULT => " WHERE  `Key`!='MUL'"
    . " and `Type` !='datetime'" // date ajout et date modifier
    . " and `Type` !='varchar(199)'", // password
    //COLUMNS_master
    MODE_SELECT_Interface::_MASTER => " WHERE (`null`='no' "
    . "and `Type` !='datetime' " // date ajout et date modifier
    . "and `Type` !='varchar(201)'" // text 
    . " and  `Type` !='varchar(20)' " // telephone
    . "and `Key`!='MUL' "
    . "and `Type` !='varchar(199)')", //password
    //COLUMNS_all
    MODE_SELECT_Interface::_ALL => " WHERE  `Key`!='MUL' "
];
/**
 * select table relation auto avec trois mode
 */
$select_relations_table = ["CHILDREN" => [
        MODE_SELECT_Interface::_DEFAULT => " WHERE  `Key`!='MUL' and `Type` !='datetime' ",
        MODE_SELECT_Interface::_MASTER => " WHERE `null`='no' and `Type` !='datetime' and `Type` !='varchar(201)' and `Type` !='varchar(20)' and `Key`!='MUL' ",
        MODE_SELECT_Interface::_ALL => " WHERE `Key`!='MUL' "
    ]
];
/**
 * les outils 
 */
$select_tools_table = [
    "COLUMNS_META" => " DESCRIBE ",
    "FOREIGN_KEY" => " WHERE `Key`='MUL'",
    "FILES" => " WHERE `Type` ='varchar(250)'",
    "STATISTIQUE" => " WHERE `Type` ='int(12)'"
];

return array_merge($select_native_table, $select_tools_table, $select_relations_table);

