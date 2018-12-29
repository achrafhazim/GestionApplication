<?php

namespace Kernel\INTENT;

use Kernel\Tools\Tools;
use TypeError;
use function array_keys;
use function in_array;

class Intent_Set extends Intent
{
   //to model
    const MODE_INSERT = ["INSERT"];
    const MODE_UPDATE = ["UPDATE"];
    const MODE_FORM = ["FORM"];
    
    function __construct($entitysSchema, $entitysDataTables, $mode = self::MODE_FORM)
    {
        if (!in_array($mode, [self::MODE_FORM, self::MODE_UPDATE, self::MODE_INSERT])) {
            if (!empty($entitysDataTables) and ! Tools::isAssoc($entitysDataTables)) {
                throw new TypeError("mode error set");
            }
        }
        parent::__construct($entitysSchema, $entitysDataTables, $mode);
    }
    /**
     * get id table child
     * @return array
     */
    public function get_Data_CHILDREN_id() : array
    {
        
        $data = ($this->getEntitysDataTable()[0]);
        $name_CHILDRENs = (array_keys($this->getEntitysSchema()->getCHILDREN())); // name childern array
        $dataCHILDRENs = [];
        foreach ($name_CHILDRENs as $name_CHILDREN) {
            if (isset($data->$name_CHILDREN)) {
                $dataCHILDRENs[$name_CHILDREN] = $data->$name_CHILDREN; // charge $dataCHILDREN
            }
        }

        return $dataCHILDRENs;
    }
    /**
     * get datatabe  assoc
     * @return array
     */
    public function get_Data_Table(): array
    {
        $data = ($this->getEntitysDataTable()[0]);
        $name_CHILDRENs = (array_keys($this->getEntitysSchema()->getCHILDREN())); // name childern array
        foreach ($name_CHILDRENs as $name_CHILDREN) {
            if (isset($data->$name_CHILDREN)) {
                unset($data->$name_CHILDREN); // remove CHILDREN in $data
            }
        }
        return Tools::entitys_TO_array($data);
    }
}
