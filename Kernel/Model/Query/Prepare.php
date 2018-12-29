<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Query;

/**
 * Description of Prepare
 *
 * @author wassime
 */
class Prepare
{

    private $prepare="";
    private $execute=[];
    
    
    
    function __construct(string $prepare, array $execute)
    {
        $this->prepare = $prepare;
        $this->execute = $execute;
    }

    
    function getPrepare(): string
    {
        return $this->prepare;
    }

    function getExecute() : array
    {
        return $this->execute;
    }

    function setPrepare(string $prepare)
    {
        $this->prepare = $prepare;
    }

    function setExecute(array $execute)
    {
        $this->execute = $execute;
    }
}
