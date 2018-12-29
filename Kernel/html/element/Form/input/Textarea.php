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
 * Description of Textarea
 *
 * @author wassime
 */
class Textarea extends Abstract_Input
{
/**
 *
 * @return string
 */
    public function builder_Tag(): string
    {

        $name = $this->name;
        $id_html = $this->id_html;
        $Default = $this->Default;

        $tag = $inputHTML = HTML::TAG("textarea")
                ->setClass(" form-control input-sm")
                ->setAtt('  data-set_null="' . $this->null . '"  autocomplete="text"')
                ->setId($id_html)
                ->setName($name . $this->child)
                ->setPlaceholder(str_replace(["_","$"], " ", $name))
                ->setValue($Default)
                ->setData($Default)
                ->setTag("textarea")
                ->builder();
        return $tag;
    }
}
