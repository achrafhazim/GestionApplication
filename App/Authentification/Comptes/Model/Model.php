<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author wassime
 */

namespace App\Authentification\Comptes\Model;

use App\AbstractModules\Model\Model as m;

class Model extends m
{

    public function login(string $login): array
    {

        if (empty($login) || $login == "") {
            return [];
        }
        $schema = $this->getSchema();

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $compte = $this->prepareQueryAssoc(
                self::Get_QuerySQL()->select()
                            ->from($schema->getNameTable())
                            ->where(["email" => $login])
                ->prepareQuery()
            );
        } else {
            $compte = $this->prepareQueryAssoc(
                self::Get_QuerySQL()->select()
                            ->from($schema->getNameTable())
                            ->where(["login" => $login])
                ->prepareQuery()
            );
        }




        if (empty($compte)) {
            return [];
        } else {
            return $compte[0];
        }
    }

    public function autorisation(array $compte, array $tableAutorisations)
    {
        $id_compte = $compte["id"];
        $autorisation = [];


        foreach ($tableAutorisations as $tableAutorisation) {
            $autorisation[$tableAutorisation] = $this->getRool($tableAutorisation, $id_compte);
        }
        return $autorisation;
    }

    private function getRool($tableAutorisation, $id_compte): array
    {
        $rool = $this->prepareQueryAssoc(
            self::Get_QuerySQL()->select()
                        ->from($tableAutorisation)
                        ->where(["comptes" => $id_compte])
            ->prepareQuery()
        );

        /**
         * change index nompbre to arra assoc par index name controller
         */
        $per = [];
        foreach ($rool as $row) {
            $controler = $row['controller'];
            $per[$controler] = $row;
        }

        return $per;
    }
}
