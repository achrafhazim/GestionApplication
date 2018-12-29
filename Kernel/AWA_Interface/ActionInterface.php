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
interface ActionInterface
{

    public function name_add(): string;

    public function name_update(): string;

    public function name_delete(): string;

    public function name_show(): string;

    public function name_message(): string;

    function setAction($action);

    public function is_add(): bool;

    public function is_update(): bool;

    public function is_delete(): bool;

    public function is_show(): bool;

    public function is_message(): bool;

    public function is_index(): bool;
}
