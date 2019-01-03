<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Controller;

use Kernel\AWA_Interface\ActionInterface;

/**
 * Description of Action
 *
 * @author wassime
 */
class Action implements ActionInterface
{

    private $add;
    private $update;
    private $delete;
    private $show;
    private $message;
    private $action;

    /**
     *
     * @param string $add
     * @param string $update
     * @param string $delete
     * @param string $show
     * @param string $message
     */
    function __construct(
        string $add = "add",
        string $update = "update",
        string $delete = "delete",
        string $show = "show",
        string $message = "message"
    ) {
        $this->add = $add;
        $this->update = $update;
        $this->delete = $delete;
        $this->show = $show;
        $this->message = $message;
    }

    /**
     *
     * @return string
     */
    public function name_add(): string
    {
        return $this->add;
    }

    /**
     *
     * @return string
     */
    public function name_update(): string
    {
        return $this->update;
    }

    /**
     *
     * @return string
     */
    public function name_delete(): string
    {
        return $this->delete;
    }

    /**
     *
     * @return string
     */
    public function name_show(): string
    {
        return $this->show;
    }

    /**
     *
     * @return string
     */
    public function name_message(): string
    {
        return $this->message;
    }

    /**
     *
     * @param type $action
     */
    function setAction($action)
    {
        $this->action = $action;
    }

    /**
     *
     * @return bool
     */
    public function is_add(): bool
    {
        return $this->add === $this->action;
    }

    /**
     *
     * @return bool
     */
    public function is_update(): bool
    {
        return $this->update === $this->action;
    }

    /**
     *
     * @return bool
     */
    public function is_delete(): bool
    {
        return $this->delete === $this->action;
    }

    /**
     *
     * @return bool
     */
    public function is_show(): bool
    {
        return $this->show === $this->action;
    }

    /**
     *
     * @return bool
     */
    public function is_message(): bool
    {
        return $this->message === $this->action;
    }

    /**
     *
     * @return bool
     */
    public function is_index(): bool
    {
        return "index" === strtolower($this->action) || "" === $this->action || null == $this->action;
    }
}
