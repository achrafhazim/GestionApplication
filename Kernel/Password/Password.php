<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of password
 *
 * @author wassime
 */

namespace Kernel\Password;

use Kernel\AWA_Interface\PasswordInterface;
use const PASSWORD_BCRYPT;
use function password_hash;
use function password_verify;

class Password implements PasswordInterface
{

    private $algo;
    private $options;

    function __construct(int $algo = -1, array $options = [])
    {
        if ($algo === -1) {
            $algo = PASSWORD_BCRYPT;
        }
        if (empty($options)) {
            $options = [
                'cost' => 12,
            ];
        }
        $this->algo = $algo;
        $this->options = $options;
    }

    /**
     * Creates a password hash
     * @param string $password
     * @return string
     */
    public function encrypt(string $password): string
    {

        return password_hash($password, $this->algo, $this->options);
    }

    /**
     * Vérifie qu'un mot de passe correspond à un hachage
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
