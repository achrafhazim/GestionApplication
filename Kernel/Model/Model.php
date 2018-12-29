<?php

namespace Kernel\Model;

use Kernel\AWA_Interface\ModelInterface;
use Kernel\Model\Base_Donnee\SetData;

class Model extends SetData implements ModelInterface
{

    public function __construct($PathConfigJson, $PathCashJson, $table = null) {
        parent::__construct($PathConfigJson, $PathCashJson, $table);
        
    }



}
