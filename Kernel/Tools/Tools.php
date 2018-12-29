<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parse
 *
 * @author wassime
 */

namespace Kernel\Tools;

use ReflectionClass;
use function array_keys;
use function count;
use function date;
use function get_class;
use function is_array;
use function json_decode;
use function json_encode;
use function range;
use function str_replace;
use function strtotime;

class Tools
{

    public static function date_FR_to_EN($var)
    {

        $date = str_replace('/', '-', $var);
        return date('Y-m-d', strtotime($date));
    }

    public static function date_EN_to_FR($var)
    {

        $date = str_replace('-', '/', $var);
        return date('d/m/Y', strtotime($date));
    }

    public static function isAssoc(array $arr): bool
    {
        if (array() === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public static function entitys_TO_array($object, string $nameTable = ""): array
    {
        $array = json_decode(json_encode($object), true);

        if ($nameTable != "") {
            $array_new = [];
            foreach ($array as $key => $value) {
                $key = str_replace($nameTable . "_", "", $key);
                $array_new[$key] = $value;
            }
            return $array_new;
        }

        return $array;
    }

    public static function json($object)
    {

        return json_encode($object);
    }

    public static function json_js($data)
    {
/// datatable js setdatapar (titles ... and dataset ....)
// https://datatables.net/examples/data_sources/js_array.html

        $titles = [];
        $dataSets = [];
        foreach ($data as $rom) {
            $title = [];
            $dataSet = [];
            foreach ($rom as $t => $d) {
                $title[] = ["title" => $t];
                $dataSet[] = $d;
            }
            $titles = $title;
            $dataSets[] = $dataSet;
        }

        /// datatable js setdatapar (titles ... and dataset ....)
        return self::json(["titles" => $titles, "dataSet" => $dataSets]);
    }

    public static function parse_object_TO_array($object): array
    {

        if (is_array($object)) {
            return $object;
        }
        $reflectionClass = new ReflectionClass(get_class($object));
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }

        return $array;
    }
}
