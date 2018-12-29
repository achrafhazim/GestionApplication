<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form\input;

use Kernel\html\element\Form\input\Schema_Input_HTML;
use Kernel\INTENT\Schema_Form;
use function str_replace;

/**
 * Description of Abstract_Input
 *
 * @author wassime
 */
abstract class Abstract_Input
{

    /**
     *
     * @var Schema_Form
     */
    protected $name = "";

    /**
     *
     * @var string || array
     */
    protected $Default = "";
    protected $Data_load = [];
    protected $lable = "";
    protected $id_html = "";
    protected $input;
    protected $type = "";
    protected $null;
    protected $child = "";
    protected $is_hidden = false;

    function __construct(Schema_Input_HTML $input)
    {
        $this->input = $input;
        $this->name = $input->getName();
        $this->id_html = $input->getId_html();
        $this->Default = $input->getDefault();
        $this->Data_load = $input->getData_load();
        $this->type = strtolower($input->getType());
        $this->null = $input->getIsNull();
       
        $this->lable = str_replace(["_", "$"], " ", $input->getName());
        if ($this->type === "hidden") {
            $this->is_hidden = true;
        }
    }

    /**
     *
     * @return string
     */
    function getName(): string
    {
        return $this->name;
    }

    /**
     * select or inpute normal
     * @return string | array
     */
    function getDefault()
    {
        return $this->Default;
    }

    /**
     * data charge for select or multi select
     * @return array
     */
    function getData_load(): array
    {
        return $this->Data_load;
    }

    /**
     *
     * @return string
     */
    function getLable(): string
    {


        if ($this->null=="NO") {
            $this->lable .= ' <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ';
        }
        if ($this->is_hidden) {
            $this->lable = "";
        }

        return $this->lable;
    }

    /**
     * get input html
     */
    abstract function builder_Tag(): string;

    /**
     * "_child" controe send
     * @param type $namechild
     * @return \self
     */
    function setChild($namechild = "_child"): self
    {
        $this->child = "[]";
        $this->name .= $namechild;
        $this->id_html .= $namechild;
        return $this;
    }
}
