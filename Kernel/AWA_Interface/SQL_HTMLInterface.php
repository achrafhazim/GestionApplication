<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\AWA_Interface;

/**
 *
 * @author wassime
 */
interface SQL_HTMLInterface
{
    /*
     "text": "textarea",
    "date": "date",
    "tinyint(4)": "checkBox",
    "varchar(20)": "tel",
    "varchar(150)": "email",
    "varchar(200)": "text",
    "varchar(201)": "text",
    "varchar(202)": "password",
    "varchar(250)": "file",
    "int(10)": "hidden",
    "int(11)": "select",
    "double": "number",
    "datetime": "hidden"
     */

    const HTML_SQL =
                [
                "tel" =>         ["typeHtml"=>"tel",        "typePhinix" => "string",     "options" => ['limit' => 20, 'null' => true,'default' => '']],
                "email" =>       ["typeHtml"=>"email",      "typePhinix" => "string",     "options" => ['limit' => 150, 'null' => true,'default' => '']],
                "email_master" =>["typeHtml"=>"email",      "typePhinix" => "string",     "options" => ['limit' => 151]],
                "text_master" => ["typeHtml"=>"text",       "typePhinix" => "string",     "options" => ['limit' => 200]],
                "password" =>    ["typeHtml"=>"password",   "typePhinix" => "string",     "options" => ['limit' => 199]],
                "text" =>        ["typeHtml"=>"text",       "typePhinix" => "string",     "options" => ['limit' => 201, 'null' => true,'default' => '']],
                "file" =>        ["typeHtml"=>"file",       "typePhinix" => "string",     "options" => ['limit' => 250, 'null' => true,'default' => '']],
                "textarea" =>    ["typeHtml"=>"textarea",   "typePhinix" => "text",       "options" => ['null' => true]],
                "date" =>        ["typeHtml"=>"date",       "typePhinix" => "date",       "options" => []],
                "checkBox" =>    ["typeHtml"=>"checkBox",   "typePhinix" => "integer",    "options" => ['limit' => 4, 'null' => true,'default' => 0]],
                "number" =>      ["typeHtml"=>"number",     "typePhinix" => "integer",    "options" => ['limit' => 12]],
                "double" =>      ["typeHtml"=>"number",     "typePhinix" => "double",     "options" => []], /// alias integer
                "select" =>      ["typeHtml"=>"select",     "typePhinix" => "integer",    "options" => ['limit' => 11]],
                "id" =>          ["typeHtml"=>"hidden",     "typePhinix" => "integer",    "options" => ['limit' => 10, 'identity' => true]],
                "add_update" =>  ["typeHtml"=>"hidden",     "typePhinix" => "datetime",   "options" => [] ]
                    ];
}
