<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\AWA_Interface;

/**
 *
 * @author wassime
 */
interface NamesRouteInterface
{

    function __construct($ajax = "_Ajax", $files = "_Files", $send = "_Send", $show = "_Show");

    public function set_NameModule(string $nameModule = "");
    public function set_NameRoute(string $nameRoute);

    public function ajax(): string;

    public function files(): string;

    public function send(): string;

    public function show(): string;

    public function is_ajax(): bool;

    public function is_files(): bool;

    public function is_send(): bool;

    public function is_show(): bool;
}
