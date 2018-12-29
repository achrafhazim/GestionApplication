<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\Components;

use Kernel\html\HTML;

/**
 * Description of Panel
 *
 * @author wassime
 */
class Panel
{

    private $title;
    private $body;

    function __construct(string $title, string  $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public function builder()
    {
        $heading= $this->heading();
        $body= $this->body();
        return   HTML::TAG("div")
                ->setClass("panel panel-default")
                ->setAtt('style="margin:10px"')
                ->setData($heading.$body)
                ->builder();
    }

    private function heading()
    {
        
        $h3=HTML::TAG("h3")
                ->setClass("panel-title")
                ->setData($this->title)
                ->builder();
        
         return   HTML::TAG("div")
                 ->setClass("panel-heading")
                 ->setData($h3)
                 ->builder();
    }

    private function body()
    {
         return   HTML::TAG("div")
                 ->setClass("panel-body ")
                 ->setData($this->body)->builder();
    }
}
