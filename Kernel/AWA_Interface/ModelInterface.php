<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author wassime
 */
namespace Kernel\AWA_Interface;

use Kernel\AWA_Interface\Base_Donnee\ActionDataBaseInterface;
use Kernel\AWA_Interface\Base_Donnee\ConnectionInterface;
use Kernel\AWA_Interface\Base_Donnee\MetaDatabaseInterface;
use Kernel\AWA_Interface\Base_Donnee\SelectInterface;
use Kernel\AWA_Interface\Base_Donnee\SetDataInterface;

interface ModelInterface extends SelectInterface, ActionDataBaseInterface, ConnectionInterface, MetaDatabaseInterface, SetDataInterface
{
  
}
