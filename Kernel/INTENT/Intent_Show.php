<?php

namespace Kernel\INTENT;

use Kernel\AWA_Interface\Base_Donnee\MODE_SELECT_Interface;
use Kernel\Model\Entitys\EntitysDataTable;
use TypeError;

class Intent_Show extends Intent implements MODE_SELECT_Interface
{

    function __construct($entitysSchema, $entitysDataTables, $mode)
    {

        foreach ($entitysDataTables as $entitysDataTable) {
            if ($entitysDataTable instanceof EntitysDataTable) {
            } else {
                throw new TypeError("type array entre ERROR ==> EntitysDataTable mode:: MODE_SELECT ");
            }
        }

        parent::__construct($entitysSchema, $entitysDataTables, $mode);
    }

    //TOOLS
    // for show


    public static function is_show_DEFAULT($_intentORmode): bool
    {
        $mode = self::parseMode($_intentORmode);

        return $mode[0] === self::_DEFAULT;
    }

    public static function is_show_MASTER($_intentORmode): bool
    {
        $mode = self::parseMode($_intentORmode);

        return $mode[0] === self::_MASTER;
    }

    public static function is_show_ALL($_intentORmode): bool
    {
        $mode = self::parseMode($_intentORmode);
        return $mode[0] === self::_ALL;
    }

    public static function is_get_CHILDREN($_intentORmode): bool
    {
        $mode = self::parseMode($_intentORmode);

        return $mode[1] !== self::_NULL;
    }

    private static function parseMode($_intentORmode): array
    {
        if ($_intentORmode instanceof self) {
            return $_intentORmode->getMode();
        } elseif (is_array($_intentORmode) && count($_intentORmode) == 2) {
            return $_intentORmode;
        } else {
            throw new \TypeError(" Error mode ");
        }
    }
}
