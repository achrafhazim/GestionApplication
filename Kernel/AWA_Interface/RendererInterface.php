<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Renderer
 *
 * @author wassime
 */

namespace Kernel\AWA_Interface;

interface RendererInterface
{

  
    
    public static function getRenderer(string $path = "");
   

    public function addPath(string $path, string $namespace);
   

    public function render(string $view, array $param = []): string;
 

    public function addGlobal(string $key, $value);
}
