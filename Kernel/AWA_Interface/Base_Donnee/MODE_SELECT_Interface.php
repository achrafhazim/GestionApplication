<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\AWA_Interface\Base_Donnee;

/**
 *
 * @author wassime
 */
interface MODE_SELECT_Interface
{

    const _DEFAULT = "DEFAULT";
    const _MASTER = "MASTER";
    const _ALL = "ALL";
    const _NULL = "EMPTY";



    /*     * ************* */
    const MODE_SELECT_DEFAULT_DEFAULT = [self::_DEFAULT, self::_DEFAULT];
    const MODE_SELECT_DEFAULT_MASTER = [self::_DEFAULT, self::_MASTER];
    const MODE_SELECT_DEFAULT_ALL = [self::_DEFAULT, self::_ALL];
    const MODE_SELECT_DEFAULT_NULL = [self::_DEFAULT, self::_NULL];
    /*     * ************* */
    const MODE_SELECT_MASTER_DEFAULT = [self::_MASTER, self::_DEFAULT];
    const MODE_SELECT_MASTER_MASTER = [self::_MASTER, self::_MASTER];
    const MODE_SELECT_MASTER_ALL = [self::_MASTER, self::_ALL];
    const MODE_SELECT_MASTER_NULL = [self::_MASTER, self::_NULL];
    /*     * ************* */
    const MODE_SELECT_ALL_DEFAULT = [self::_ALL, self::_DEFAULT];
    const MODE_SELECT_ALL_MASTER = [self::_ALL, self::_MASTER];
    const MODE_SELECT_ALL_ALL = [self::_ALL, self::_ALL];
    const MODE_SELECT_ALL_NULL = [self::_ALL, self::_NULL];

    /*     * ************* */
}
