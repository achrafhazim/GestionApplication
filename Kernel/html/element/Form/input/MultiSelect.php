<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form\input;

use Kernel\html\element\Form\input\Abstract_Input;
use Kernel\html\HTML;

/**
 * Description of MultiSelect
 *
 * @author wassime
 */
class MultiSelect extends Abstract_Input
{

    public function builder_Tag(): string
    {
        $name = $this->name;
        $id_html = $this->id_html;

        $Default = $this->value_att($this->Default);
        $data_load = $this->value_att($this->Data_load);

/////////////////////////////////////////////////////////////////
        $optionTag = $this->chargeOption($data_load, $Default);
        $Multiselecttag = HTML::TAG("select")
                ->setAtt(' multiple ')
                ->setAtt('  data-set_null="' . $this->null . '" ')
                ->setClass("  form-control ")
                ->setId($id_html)
                ->setName($name . '[]')
                ->setData($optionTag)
                ->builder();
        return $Multiselecttag;
    }

    /**
     * pour java script (jquery multi select)
     * data-value
     * @param array $data
     * @return array
     */
    private function value_att(array $data): array
    {

        $data_value_att = [];
        foreach ($data as $row) {
            $ligne = "";
            $att_data_html = "";
            foreach ($row as $column => $value) {
                $ligne .= $column . '$$$' . $value . ' £££ ';
                $att_data_html .= " data-content_" . $column . '="' . $value . '" ';
            }

            $row_id = $row["id"];

            $data_value_att[$row_id] = ["value" => $ligne, "att" => $att_data_html];
        }
        return $data_value_att;
    }

    /**
     * charge les Options par data default and data load
     * @param array $data_load
     * @param array $Default
     * @return array
     */
    private function chargeOption(array $data_load, array $Default): array
    {
        $optionTag = [];
        foreach ($data_load as $id => $data) {
            $optionTag [] = HTML::TAG('option')
                            ->setValue($id)
                            ->setAtt($data["att"])
                            ->setData($data["value"])->builder();
        }
        foreach ($Default as $id => $data) {
            $optionTag [] = HTML::TAG('option')
                            ->setValue($id)
                            ->setAtt($data["att"] . '  selected ')
                            ->setData($data["value"])->builder();
        }

        return $optionTag;
    }
}
