<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\Components;

use Kernel\html\HTML;

/**
 * Description of Box_shadow
 *
 * @author wassime
 */
class Box_shadow
{

    private $title;
    private $body;
    private $px;

    function __construct($title, $body, $px = 24)
    {

        $this->title = $title;
        $this->body = $body;
        $this->px = $px;
    }

    public function builder()
    {
        $heading = $this->heading();
        $body = $this->body();
        return HTML::TAG("div")
                        ->setClass("box shadow-" . $this->px . "dp")
                        ->setAtt('style="margin:10px"')
                        ->setData($heading . $body)
                        ->builder();
    }

    private function heading()
    {



        $h4 = HTML::TAG("h4")
                ->setData($this->title)
                ->setClass('pull-right')
                ->builder();


        return HTML::TAG("header")
                        ->setData($h4)
                        ->builder();
    }

    private function body()
    {
        return HTML::TAG("div")
                        ->setClass("box-body")
                        ->setData($this->body)->builder();
    }
}
