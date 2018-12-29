<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Authentification;

use Kernel\AWA_Interface\ModelInterface;
use function array_merge;
use function array_unique;
use function in_array;

/**
 * Description of Autorisation
 *
 * @author wassime
 */
class Autorisation_Event implements AutorisationInterface
{

    private $model;
    private $modules;

    public function __invoke($event)
    {


        foreach ($this->modules as $module) {
            $controllers = [];
            foreach ($module->getControllers() as $controller) {
                $controllers[] = $controller;
            }

            $this->Autorisation_init($module::NameModule, $controllers);
        }
    }

    function __construct(ModelInterface $model, array $modules = [])
    {
        $this->model = $model;
        $this->modules = $modules;
    }

    /**
     * save id table to 'autorisation$' . $nameModul
     * avec data default si not set
     */
    public function Autorisation_init(string $nameModul, array $namecontrollers)
    {
        //  var_dump($nameModul,$namecontrollers);die();
        /**
         * get id comptees save
         */
        $id_comptes = $this->get_idCompes();


        /**
         * get id competes save to table ==>
         * 'autorisation$' . $nameModul
         */
        $id_comptes_setModule = $this->get_FOREIGN_KEY_Compes($nameModul);

        /**
         * save id table to 'autorisation$' . $nameModul
         * avec data default si not set
         *
         * init si delete all  FOREIGN_KEY_Compes to table
         */
        foreach ($id_comptes as $id) {
            // init si delete all  FOREIGN_KEY_Compes to table
//$id==1 is root
            if ($id != 1 && !in_array($id, $id_comptes_setModule)) {
                // model

                $this->model->setTable(self::Prefixe . $nameModul);


                // set data to table 'autorisation$' . $nameModul
                foreach ($namecontrollers as $namecontroller) {
                    $data = array_merge(["controller" => $namecontroller], ["comptes" => $id]);
                    $this->model->insert_table_Relation($data);
                }
            }
        }
    }

    /**
     * get id comptees save
     */
    private function get_idCompes(): array
    {

        $id_comptes = [];
        $this->model->setTable("comptes");
        foreach ($this->model->select_simple(["id"]) as $value) {
            $id_comptes[] = $value["id"];
        }
        return $id_comptes;
    }

    /**
     * get id competes save to table ==>
     * 'autorisation$' . $nameModul
     */
    private function get_FOREIGN_KEY_Compes($nameModul): array
    {

        $this->model->setTable(self::Prefixe . $nameModul);
        $id_comptes_setModule = [];

        foreach ($this->model->select_simple(["comptes"]) as $value) {
            $id_comptes_setModule[] = $value["comptes"];
        }

        return array_unique($id_comptes_setModule);
    }
}
