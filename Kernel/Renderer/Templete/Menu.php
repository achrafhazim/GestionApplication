<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author wassime
 */
namespace Kernel\Renderer\Templete;

class Menu
{
    private $nav_title="";
    private $nav_icon="";
    private $nav_array=[];
    
    function __construct($nav_title, $nav_icon, $nav_array)
    {
        $this->nav_title = $nav_title;
        $this->nav_icon = $nav_icon;
        $this->nav_array = $nav_array;
    }
}
