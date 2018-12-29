<?php

namespace Kernel\Model\Entitys;

use Kernel\Tools\Tools;

class EntitysDataTable
{
    private $null=false;
    private $DataJOIN = [];

//add item enfant


    public function setDataJOIN($key, $enfant)
    {
        $this->DataJOIN[$key] = $enfant;
    }

    public function getDataJOIN($key = null)
    {
        if ($key == null) {
            return $this->DataJOIN;
        } else {
            return $this->DataJOIN[$key];
        }
    }

    public function set(array $data): array
    {
        if (Tools::isAssoc($data)) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
        }
        return [$this];
    }
    
    function is_Null(): bool
    {
        return $this->null;
    }

    function setNull($null = true)
    {
        $this->null = $null;
    }
}
