<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class Unites extends AbstractMigration
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
        $reglage = 'unites';
        $this->table($reglage, HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master($reglage))
                ->addColumn(HTML_Phinx::textarea("Symbole"))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addIndex([$reglage], ['unique' => true])
                ->create();
        $this->seed($reglage);
    }

    public function seed($reglage)
    {
        $faker = Faker\Factory::create('fr_FR');
        $date = date("Y-m-d H:i:s", $faker->unixTime('now'));
        $data = [
            [
                $reglage => "Année",
                "Symbole" => " A ",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Gramme",
                "Symbole" => "g",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Heure",
                "Symbole" => "h",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Image",
                "Symbole" => "img",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Jour",
                "Symbole" => "Jour",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Kilogramme",
                "Symbole" => "Kg",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Kilomètre",
                "Symbole" => "Km",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Litre",
                "Symbole" => "l",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Mètre",
                "Symbole" => "m",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Mètre carré",
                "Symbole" => "m2",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Chèque",
                "Symbole" => " h ",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Mètre cube",
                "Symbole" => "m3",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Mètre linéaire",
                "Symbole" => "ml",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Minute",
                "Symbole" => "min",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Mois",
                "Symbole" => "M",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Personne",
                "Symbole" => "p",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Seconde",
                "Symbole" => "s",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Tonne",
                "Symbole" => "T",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "hectare",
                "Symbole" => "ha",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [$reglage => "Unité",
                "Symbole" => "U",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ]];

        $this->table($reglage)->insert($data)->save();
    }
}
