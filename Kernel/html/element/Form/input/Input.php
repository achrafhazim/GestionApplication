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
 * Description of Input
 *
 * @author wassime
 */
class Input extends Abstract_Input
{

    /**
     *
     * @return string
     */
    public function builder_Tag(): string
    {
        $name = $this->name;
        $placeholder = str_replace(["_", "$"], " ", $name);
        $id_html = $this->id_html;
        $type = $this->type;


        $tag = HTML::TAG('input')
                ->setId($id_html)
                ->setType($type)
                ->setPlaceholder($placeholder)
                ->setClass("  form-control input-sm ");


        if ($type == "file") {
            $tag = $this->input_file($tag);
        } elseif ($type == "checkbox") {
            $tag = $this->input_checkbox($tag);
        } elseif ($type == "password") {
            $tag = $this->input_password($tag);
        } else {
            $tag = $this->input_normal($tag);
        }

        return $tag->builder();
    }

    /**
     * is type file
     * @param HTML $tag
     * @return HTML
     */
    private function input_file(HTML $tag): HTML
    {
        $name = $this->name;
        if ($this->child != "[]") {
            $tag->setAtt('multiple ');
            $tag->setName($name . "[]");
        } else {
            $tag->setName($name . "_");
        }

        return $tag;
    }

    /**
     * is type checkbox
     * @param HTML $tag
     * @return HTML
     */
    private function input_checkbox(HTML $tag): HTML
    {
        $name = $this->name;
        $Default = $this->Default;
        $tag->setName($name . $this->child)
                ->setValue($name . $this->child);
        if ($Default == "1" || $Default == 1) {
            $tag->setAtt("checked");
        }
        return $tag;
    }
 /**
     * default input
     * @param HTML $tag
     * @return HTML
     */
    private function input_password(HTML $tag): HTML
    {
        $name = $this->name;
       
        $tag->setName($name . $this->child)
                ->setAtt('data-set_null="' . $this->null . '"  step="any" ')
                ;
        return $tag;
    }
    /**
     * default input
     * @param HTML $tag
     * @return HTML
     */
    private function input_normal(HTML $tag): HTML
    {
        $name = $this->name;
        $Default = $this->Default;
        $tag->setName($name . $this->child)
                ->setAtt('data-set_null="' . $this->null . '"  step="any" ')
                ->setValue($Default);
        return $tag;
    }
}
