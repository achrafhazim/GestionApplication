<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller;

use Kernel\AWA_Interface\NamesRouteInterface;

/**
 * Description of NamesRoute
 *
 * @author wassime
 */
class NamesRoute implements NamesRouteInterface
{

    private $ajax;
    private $files;
    private $send;
    private $show;
    private $nameModule="";
    private $nameRoute="'";

    function __construct($ajax = "_Ajax", $files = "_Files", $send = "_Send", $show = "_Show")
    {
        $this->ajax = $ajax;
        $this->files = $files;
        $this->send = $send;
        $this->show = $show;
    }

    public function set_NameModule(string $nameModule = "")
    {
        $this->nameModule = $nameModule;
    }

    public function ajax(): string
    {

        return $this->nameModule . $this->ajax;
    }

    public function files(): string
    {
        return $this->nameModule . $this->files;
    }

    public function send(): string
    {
        return $this->nameModule . $this->send;
    }

    public function show(): string
    {
        return $this->nameModule . $this->show;
    }

    public function is_ajax(): bool
    {

        if (preg_match("/[^.]+" . $this->ajax . "/i", $this->nameRoute)) {
            return true;
        } else {
            return false;
        }
    }

    public function is_files(): bool
    {
        if (preg_match("/[^.]+" . $this->files . "/i", $this->nameRoute)) {
            return true;
        } else {
            return false;
        }
    }

    public function is_send(): bool
    {
        if (preg_match("/[^.]+" . $this->send . "/i", $this->nameRoute)) {
            return true;
        } else {
            return false;
        }
    }

    public function is_show(): bool
    {
        if (preg_match("/[^.]+" . $this->show . "/i", $this->nameRoute)) {
            return true;
        } else {
            return false;
        }
    }

    public function set_NameRoute(string $nameRoute)
    {
        $this->nameRoute=$nameRoute;
    }
}
