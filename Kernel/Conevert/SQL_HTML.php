<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Conevert;

use Kernel\AWA_Interface\SQL_HTMLInterface;

/**
 * Description of Phinx_HTML
 *
 * @author wassime
 */
class SQL_HTML implements SQL_HTMLInterface
{

    /**
      'varchar(20)' => 'tel',
      'varchar(150)' => 'email',
      'varchar(200)' => 'text',
      'varchar(201)' => 'text',
      'varchar(250)' => 'file',
      'text' => 'textarea',
      'date' => 'date',
      'int(4)' => 'checkBox',
      'int(12)' => 'number',
      'int(11)' => 'select',
      'int(10)' => 'hidden

     */
    private static function getType(string $typesqle): string
    {

        if (preg_match("/varchar/i", $typesqle)) {
            return "string";
        } elseif (preg_match("/text/i", $typesqle)) {
            return "text";
        } elseif (preg_match("/int/i", $typesqle)) {
            return "integer";
        } elseif (preg_match("/datetime/i", $typesqle)) {
            return "datetime";
        } elseif (preg_match("/date/i", $typesqle)) {
            return "date";
        } elseif (preg_match("/double/i", $typesqle)) {
            return "double";
        } else {
            var_dump($typesqle);
            die();
            return $typesqle;
        }
    }

    private static function getlimit(string $typesqle)
    {

        // get numbre
        preg_match_all('/\d+/', $typesqle, $matches);
        if (isset($matches[0][0])) {
            return $matches[0][0];
        }
        return 0;
    }

    public static function getTypeHTML(string $typesqle)
    {

        $type = self::getType($typesqle);
        $limit = self::getlimit($typesqle);

        foreach (self::HTML_SQL as $params) {
            if ($params["typePhinix"] == $type) {
                if (!isset($params["options"]['limit']) ||
                        $params["options"]['limit'] == $limit) {
                    return $params["typeHtml"];
                }
            }
        }
    }
}
