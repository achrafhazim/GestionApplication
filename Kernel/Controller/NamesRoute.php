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
class NamesRoute implements NamesRouteInterface {

    private $ajax = "_Ajax";
    private $files = "_Files";
    private $send = "_Send";
    private $show = "_Show";
    private $get = "_get";
    private $post = "_post";
    private $put = "_put";
    private $delete = "_delete";
    private $nameModule = "";
    private $nameRoute = "'";

    public function set_NameModule(string $nameModule = "") {
        $this->nameModule = $nameModule;
    }

    public function ajax(): string {

        return $this->nameModule . $this->ajax;
    }

    public function files(): string {
        return $this->nameModule . $this->files;
    }

    public function send(): string {
        return $this->nameModule . $this->send;
    }

    public function show(): string {
        return $this->nameModule . $this->show;
    }

    public function get(): string {
        return $this->nameModule . $this->get;
    }

    public function post(): string {
        return $this->nameModule . $this->post;
    }

    public function put(): string {
        return $this->nameModule . $this->put;
    }

    public function delete(): string {
        return $this->nameModule . $this->delete;
    }

    public function is_ajax(): bool {

        if (preg_match("/[^.]+" . $this->ajax . "/i", $this->nameRoute)) {
            return true;
        } else {
            return false;
        }
    }

    public function is_files(): bool {
        if (preg_match("/[^.]+" . $this->files . "/i", $this->nameRoute)) {
            return true;
        } else {
            return false;
        }
    }

    public function is_send(): bool {
        if (preg_match("/[^.]+" . $this->send . "/i", $this->nameRoute)) {
            return true;
        } else {
            return false;
        }
    }

    public function is_show(): bool {
        if (preg_match("/[^.]+" . $this->show . "/i", $this->nameRoute)) {
            return true;
        } else {
            return false;
        }
    }

    public function set_NameRoute(string $nameRoute) {
        $this->nameRoute = $nameRoute;
    }

}
