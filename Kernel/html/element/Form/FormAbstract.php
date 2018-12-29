<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form;

use Kernel\html\Components\Box_shadow;
use Kernel\html\Components\Modals;
use Kernel\html\Components\Panel;
use Kernel\html\element\Form\input\Abstract_Input;
use Kernel\html\element\Form\input\Schema_Input_HTML;
use Kernel\html\HTML;
use TypeError;
use function is_a;

/**
 * Description of FormAbstract
 *
 * @author wassime
 */
abstract class FormAbstract
{

    protected $inputs = [];

    /**
     *
     * @param array Schema_Input_HTML $inputs
     */
    function __construct(array $inputs)
    {

        $flag = $this->is_Array_Schema_Input($inputs);
        if (!$flag) {
            throw new TypeError("Schema_Input_HTML error => is not inputs type Schema_Input_HTML ");
        }
        $this->inputs = $inputs;
    }

    /**
     * cheket type input
     * @param array $inputs
     * @return boolean
     */
    private function is_Array_Schema_Input(array $inputs): bool
    {
        foreach ($inputs as $input) {
            if (!is_a($input, Schema_Input_HTML::class)) {
                return false;
            }
        }
        return true;
    }

    /**
     * creer les forms html
     */
    abstract function builder_form(): string;

    /**
     * creer les style forms html
     * bootstrap
     * @param Abstract_Input $input
     * @return string
     */
    protected function style_form_horizonta(Abstract_Input $input): string
    {
        $body = $input->builder_Tag();
        $title = $input->getLable();

        $labelHTML = HTML::TAG('label')
                ->setClass("col-sm-3 control-label")
                ->setAtt(' style="text-align: left;"')
                ->setData($title)
                ->setFor($input->getName())
                ->builder();

        $inputHTML = HTML::TAG("div")
                ->setClass("col-sm-9")
                ->setData($body)
                ->builder();

        $div = HTML::TAG("div")
                ->setClass("form-group ")
                ->setData([$labelHTML, $inputHTML])
                ->builder();
        return $div;
    }

    /**
     *
     * creer les style forms html
     * bootstrap
     * @param Abstract_Input $input
     * @return string
     */
    protected function style_form_inline(Abstract_Input $input): string
    {
        $body = $input->builder_Tag();
        $title = $input->getLable();
        $labelHTML = HTML::TAG('label')
                ->setClass("control-label")
                ->setAtt(' style="text-align: left;"')
                ->setData($title)
                ->setFor($input->getName())
                ->builder();

        $inputHTML = HTML::TAG("div")
                ->setData($body)
                ->builder();

        $div = HTML::TAG("div")
                ->setClass("form-group ")
                ->setData([$labelHTML, $inputHTML])
                ->builder();
        return $div;
    }

    /**
     * creer les style forms html
     * bootstrap
     * @param Abstract_Input $input
     * @return string
     */
    protected function style_Panel(Abstract_Input $input): string
    {
        $body = $input->builder_Tag();
        $title = $input->getLable();
        $panel = (new Panel($title, $body));
        $icon = ' <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span> ';
        return ( new Box_shadow($icon, $panel->builder(), 8))
                        ->builder();
    }

    /**
     * creer les style forms html
     * bootstrap
     * @param Abstract_Input $input
     * @return string
     */
    protected function style_Modals(Abstract_Input $input): string
    {
        $body = $input->builder_Tag();
        $title = $input->getLable();
        $cont = 0;
        if (is_array($input->getDefault())) {
            $cont += count($input->getDefault());
        }
        if (is_array($input->getData_load())) {
            $cont += count($input->getData_load());
        }


        $modal = new Modals($title, $body, "", $cont);

        return $modal->builder();
    }
}
