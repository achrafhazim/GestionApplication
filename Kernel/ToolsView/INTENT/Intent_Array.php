<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\ToolsView\INTENT;

use Kernel\Conevert\SQL_HTML;
use Kernel\Tools\Tools;
use Kernel\ToolsView\html\Components\input\Schema_Input_HTML;

/**
 * Description of Intent_Array
 *
 * @author wassime
 */
class Intent_Array {

    /**
     *
     * @var array schema table sql
     */
    private $COLUMNS_META = [];

    /**
     * schema table sql type array object entity
     * @param array $COLUMNS_META
     */
    function setCOLUMNS_META(array $COLUMNS_META) {
        $this->COLUMNS_META = Tools::entitys_TO_array($COLUMNS_META);
    }

    /**
     * schema input type , default ,isnull .....
     * @return array Schema_Input_HTML
     */
    function getArray_Schema_Input() {


        $Array_Schema_Input = [];
        foreach ($this->COLUMNS_META as $COLUMN_META) {
            $schema_Input_HTML = (new Schema_Input_HTML())->
                    setName($COLUMN_META['Field'])->
                    setType(SQL_HTML::getTypeHTML($COLUMN_META['Type']))
                    ->setIsNull($COLUMN_META['Null'])
                    ->setDefault($COLUMN_META['Default'])
                    ->setSefix("id_html_");
            $Array_Schema_Input[] = $this->Array_($schema_Input_HTML);
        }
        return ($Array_Schema_Input);
    }

    private function Array_(Schema_Input_HTML $Schema_Input_HTML) {
        $input = [
            "name" => $Schema_Input_HTML->getName(),
            "type" => $Schema_Input_HTML->getType(),
            "isnull" => $Schema_Input_HTML->getIsNull(),
            "default" => $Schema_Input_HTML->getDefault(),
        ];
        return $input;
    }

}
