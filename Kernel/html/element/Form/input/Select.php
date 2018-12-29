<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of select
 *
 * @author wassime
 */

namespace Kernel\html\element\Form\input;

use Kernel\html\element\Form\input\Abstract_Input;
use Kernel\html\HTML;
use Kernel\Tools\Tools;

class Select extends Abstract_Input
{

    /**
     *
     * @return string
     */
    public function builder_Tag(): string
    {
        $name = $this->name;
        $id_html = $this->id_html;
        $data_load = [];
        foreach ($this->Data_load as $row) {
            $data_load[$row["id"]] = Tools::entitys_TO_array($row);
        }



///////////////////////////////////////////////////////////////////

        $optionTag = $this->charge_options($data_load);

        $tag = HTML::TAG("select")
                ->setData($optionTag)
                ->setId($id_html)
                ->setName($name . $this->child);

        if (count($optionTag) === 1) {
            $tag = $this->select_one($tag);
        } else {
            $tag = $this->select_all($tag);
        }
        return $tag->builder();
    }

    /**
     * charg option select
     * @param array $data_load
     * @return array
     */
    private function charge_options(array $data_load): array
    {
        /// name base input (remove _child if is)
        $name = $this->input->getName();



        $optionTag = [];
        foreach ($data_load as $key => $data) {
            $rowTag = HTML::TAG('option')
                    ->setValue($key)
                    ->setData($data[$name]);

            // default value input
            $Default = $this->Default;
            if ($Default == $data[$name]) {
                $rowTag->setAtt("selected");
            }

            $rowTag = $this->att_javaScript($rowTag, $data);



            $optionTag [] = $rowTag->builder();
        }
        return $optionTag;
    }

    /**
     * pour form select show info
     * @param HTML $rowTag
     * @param array $data
     * @return HTML
     */
    private function att_javaScript(HTML $rowTag, array $data): HTML
    {

        $infocontent = "";
        $tokens = "";

        foreach ($data as $column => $value) {
            $infocontent .= $column . '$$$' . $value . ' £££ ';
            $tokens .= $value . ' ';
        }

        $rowTag->setAtt(' data-infocontent="' . $infocontent . ' "')
                ->setAtt(' data-tokens="' . $tokens . '"');

        return $rowTag;
    }

    /**
     * si input on update or show
     * @param HTML $tag
     * @return HTML
     */
    private function select_one(HTML $tag): HTML
    {
        $tag->setClass(" form-control form-string input-sm")
                ->setAtt(" readonly  ");

        if ($this->child === "[]") {
            $tag = $tag->setClass(" hidden ");
            $this->is_hidden = true;
        }
        return $tag;
    }

    /**
     * charge data loade input
     * @param HTML $tag
     * @return HTML
     */
    private function select_all(HTML $tag): HTML
    {
        $tag->setClass(" selectpicker form-control input-sm")
                ->setAtt(' data-live-search="true"  data-size="5" data-container="body" ')
                ->setAtt('  data-set_null="' . $this->null . '" ');

        return $tag;
    }
}
