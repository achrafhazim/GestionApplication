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
interface SessionInterface
{

    /**
     * Configure the session name.
     * Configure the session id
     * Set the session options.
     * Session Id regeneration
     * Set the session id regenerate interval and id expiry key name.
     */
    function __construct(
        string $name = "",
        string $id = "",
        array $options = [],
        int $regenerateIdInterval = -1,
        string $sessionIdExpiryKey = "session-id-expires"
    );

    /**
     * get data
     * @param string $key
     * @param type $default
     * @return type
     */
    public function get(string $key, $default = "");

    /**
     * set data
     * @param string $key
     * @param type $value
     */
    public function set(string $key, $value);
       /**
     * delete data
     * @param string $key
     * @param type $value
     */
    public function delete(string $key);

    /**
     * is value to key
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;
}
