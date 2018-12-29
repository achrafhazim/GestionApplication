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
interface PasswordInterface
{

    function __construct(int $algo = -1, array $options = []);

    /**
     * Creates a password hash
     * @param string $password
     * @return string
     */
    public function encrypt(string $password): string;

    /**
     * Vérifie qu'un mot de passe correspond à un hachage
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verify(string $password, string $hash): bool;
}
