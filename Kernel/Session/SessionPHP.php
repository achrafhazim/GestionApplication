<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionPHP
 *
 * @author wassime
 */

namespace Kernel\Session;

use Kernel\AWA_Interface\SessionInterface;
use RuntimeException;
use const PHP_SESSION_ACTIVE;
use const PHP_SESSION_DISABLED;
use function session_start;
use function session_status;

class SessionPHP implements SessionInterface
{

    /**

     * Configure the session name.
     * Configure the session id
     * Set the session options.
     * Session Id regeneration
     * Set the session id regenerate interval and id expiry key name.

     * session_start
     * @throws RuntimeException
     */
    function __construct(string $name = "", string $id = "", array $options = [], int $regenerateIdInterval = -1, string $sessionIdExpiryKey = "session-id-expires")
    {
        if (session_status() === PHP_SESSION_DISABLED) {
            throw new RuntimeException('PHP sessions are disabled');
        }

        if (session_status() != PHP_SESSION_ACTIVE) {
            /**
             * set name
             */
            if ($name == "") {
                $name = session_name();
            }
            session_name($name);
            /**
             * set id
             */
            if ($id == "") {
                if (isset($_COOKIE[$name]) && !empty($_COOKIE[$name])) {
                    $id = (string) $_COOKIE[$name];
                    session_id($id);
                }
            } else {
                session_id($id);
            }
            /**
             * se options
             */
            if (empty($options)) {
                session_start();
            } else {
                session_start($options);
            }

            // Session Id regeneration
            $this->IdRegeneration($regenerateIdInterval, $sessionIdExpiryKey);
        }
    }

    /**
     * get data
     * @param string $key
     * @param type $default
     * @return type
     */
    public function get(string $key, $default = "")
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return $default;
        }
    }

    /**
     * set data
     * @param string $key
     * @param type $value
     */
    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * remove|delete data
     * @param string $key
     * @param type $value
     */
    public function delete(string $key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * is value to key
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]) && !empty($_SESSION[$key]);
    }

    /**
     * Regenerate the session id if it's needed
     */
    private function IdRegeneration(int $interval = -1, string $key)
    {
        if ($interval <= 0) {
            return;
        }

        $expiry = time() + $interval;

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = $expiry;
        }

        if ($_SESSION[$key] < time() || $_SESSION[$key] > $expiry) {
            session_regenerate_id(true);
            $_SESSION[$key] = $expiry;
        }
    }
}
