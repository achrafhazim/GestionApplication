<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Renderer\Twig_Extension;

use Kernel\html\element\Form\Form_child_HTML;
use Kernel\html\element\Form\Form_view;
use Kernel\html\element\Form\FormHTML;
use Kernel\INTENT\Intent_Form;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Description of Form
 *
 * @author wassime
 */
class Form extends Twig_Extension
{

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction("form", [$this, "form"], ['is_safe' => ['html']]),
            new Twig_SimpleFunction("form_child", [$this, "form_child"], ['is_safe' => ['html']]),
            new Twig_SimpleFunction("Form_view", [$this, "Form_view"], ['is_safe' => ['html']]),
        ];
    }

    public function form(Intent_Form $Intent_Form)
    {

        $inputs = $Intent_Form->getInputsSchema();
        $formhtml = new FormHTML($inputs);
        return $formhtml->builder_form();
    }

    public function form_child(Intent_Form $Intent_Form)
    {
        $inputs = $Intent_Form->getInputsSchema();
        $formhtml = new Form_child_HTML($inputs);
        return $formhtml->builder_form();
    }

    public function Form_view(Intent_Form $Intent_Form)
    {
        $inputs = $Intent_Form->getInputsSchema();
        $formhtml = new Form_view($inputs);
        return $formhtml->builder_form();
    }
}
