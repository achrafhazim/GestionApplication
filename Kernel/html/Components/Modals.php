<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Modals
 *
 * @author wassime
 */

namespace Kernel\html\Components;

use Kernel\html\HTML;

class Modals
{

    private $name;
    private $title;
    private $body;
    private $footer;
    private $badge = "";
    private $id;
    private $id_label;

    function __construct($title, $body, $footer = "", $badge = "")
    {
        
        $name = str_replace(" ", "", $title);
        $this->name = $name;
        $this->title = str_replace(["_", "$"," "], " ", $title);
        $this->body = $body;
        $this->footer = $footer;
        if ($badge != "") {
            $this->badge = ' <span class="badge">' . $badge . '</span>';
        }

        $this->id_label = '"myModalLabel' . $this->name . '"';
        
        $this->id = 'id_Modal_' . $this->name;
    }

    function builder()
    {
        $content = $this->modal_header()
                . $this->modal_body()
                . $this->modal_footer();

        $div_content = HTML::TAG('div')
                ->setClass("modal-content")
                ->setData($content)
                ->builder();
        $div_dialog = HTML::TAG('div')
                ->setClass("modal-dialog modal-lg")
                ->setAtt('role="document" style="width: 90%;"')
                ->setData($div_content)
                ->builder();
        $div_modal = HTML::TAG('div')
                ->setClass("modal fade")
                ->setAtt(' tabindex="-1" role="dialog" aria-labelledby= ' . $this->id_label)
                ->setId($this->id)
                ->setData($div_dialog)
                ->builder();



        return $this->trigger() . $div_modal;
    }

    public function modal_header()
    {

        $span = HTML::TAG("span")
                ->setAtt('aria-hidden="true"')
                ->setData("&times;")
                ->builder();
        $btn = HTML::TAG("button")
                        ->setType("button")
                        ->setClass("close")
                        ->setAtt('data-dismiss="modal" aria-label="Close"')
                        ->setData($span)->builder();
        $h4 = HTML::TAG('h4')
                ->setClass("modal-title")
                ->setId($this->id_label)
                ->setData($this->title)
                ->builder();

        return HTML::TAG('div')
                        ->setClass("modal-header")
                        ->setData($btn . $h4)
                        ->builder();
    }

    public function modal_body()
    {
        return HTML::TAG("div")
                        ->setClass("modal-body")
                        ->setData($this->body)
                        ->builder();
    }

    public function modal_footer()
    {
        $btn = HTML::TAG("button")
                ->setType("button")
                ->setClass("btn btn-default")
                ->setAtt('data-dismiss="modal"')
                ->setData("ok")
                ->builder();
        return HTML::TAG("div")
                        ->setClass("modal-footer")
                        ->setData($this->footer . $btn)
                        ->builder();
    }

    private function trigger()
    {

        if ($this->badge == "") {
            return HTML::TAG('button')
                            ->setType("button")
                            ->setClass("btn btn-default btn-sm")
                            ->setAtt('data-toggle="modal" data-target="#' . $this->id . '"')
                            ->setData($this->title)
                            ->builder();
        } else {
            return HTML::TAG('button')
                            ->setType("button")
                            ->setClass("btn btn-primary btn-lg")
                            ->setAtt('data-toggle="modal" data-target="#' . $this->id . '"')
                            ->setData($this->title . $this->badge)
                            ->builder();
        }
    }
}
