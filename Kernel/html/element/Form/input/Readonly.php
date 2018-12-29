<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form\input;

/**
 * Description of Readonly
 *
 * @author wassime
 */
use Kernel\html\element\TableHTML;
use function str_replace;

class Readonly extends Abstract_Input
{

    public function builder_Tag(): string
    {
        $this->is_hidden = false;
        // input type multi select
        if (is_array($this->Default)) {
            return $this->data_styleTable($this->Default);
        }
        // input STD
        return $this->Default;
    }

    /**
     * is data defult array ==> multiselect
     * @param array $default
     * @param type $att
     * @return string
     */
    private function data_styleTable(array $default, $att = ' style="width:95% ; margin: auto ;" class="table table-striped table-bordered dt-responsive nowrap "'): string
    {
        if (empty($default)) {
            return "";
        }

        $heads = [];
        foreach ($default[0] as $key => $value) {
            $head = str_replace("_", " ", str_replace("$", " ", $key));
            $heads[] = $head;
        }

        $table = (new TableHTML())
                ->builder($heads, $default);


        return "<table $att >" . $table . "</table>";
    }
}
