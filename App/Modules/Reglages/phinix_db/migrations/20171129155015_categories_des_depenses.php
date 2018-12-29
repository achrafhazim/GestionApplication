<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class CategoriesDesDepenses extends AbstractMigration
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
        $reglage = 'categories$des$depenses';
        $this->table($reglage, HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master($reglage))
                ->addColumn(HTML_Phinx::textarea("note"))
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
                $reglage => "Agencements & installations	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Amortissement",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Brevets, marques & droits	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Caisses de retraite	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ],
            [
                $reglage => "CNSS & AMO	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Communication",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Comptabilité",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Cotisations et dons	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Cotisations patronales",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Déplacements, missions & réceptions",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Eau & Électricité	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Fond commercial	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Frais bancaires",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Frais de constitution",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Impôts sur les résultats",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Installations techniques",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Marchandises",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Matériel de bureau	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Matériel informatique",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Matières consommables",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Matières premières",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Mobilier de bureau	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Mutuelles	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Paiement de TVA	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Prêts au personnel	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Prêts aux associés	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Produits d'entretien	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Publicité	",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Restauration",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Retrait",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Salaires",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Téléphone & Internet",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Transport du personnel",
                "note" => "",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ]];

        $this->table($reglage)->insert($data)->save();
    }
}
