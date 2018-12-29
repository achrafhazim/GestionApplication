<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class ComptesBancaires extends AbstractMigration
{

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $reglage = 'comptes$bancaires';
        $this->table($reglage, HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master($reglage))
                ->addColumn(HTML_Phinx::text('solde$initial'))
                ->addColumn(HTML_Phinx::textarea("Designation"))
                ->addColumn(HTML_Phinx::text_master("RIB"))
                ->addColumn(HTML_Phinx::textarea("Adresse"))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addIndex(["RIB"], ['unique' => true])
                ->create();
        $this->seed($reglage);
    }

    public function seed($reglage)
    {
        $faker = Faker\Factory::create('fr_FR');
        $date = date("Y-m-d H:i:s", $faker->unixTime('now'));
        $data = [
            [
                $reglage => "Caisse",
                "RIB" => " ",
                'solde$initial' => "0",
                "Designation" => "Le compte caisse permet de représenter la valeur des espèces. Il a comme caractéristique de ne pas affecter une recette particulière à une dépense particulière. C'est le principe d'unité de caisse. Une analyse de ce compte vérifiera surtout la nature des flux de la caisse afin de vérifier d'éventuels abus de biens sociaux, vols…",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Compte bancaire",
                "RIB" => "000 ",
                'solde$initial' => "0",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ]];

        $this->table($reglage)->insert($data)->save();
    }
}
