<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class Taxes extends AbstractMigration
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
        $reglage = 'taxes';
        $this->table($reglage, HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master($reglage))
                ->addColumn(HTML_Phinx::number("Pourcentage"))
                ->addColumn(HTML_Phinx::text("note"))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                //  ->addIndex([$reglage], ['unique' => true])
                ->create();
        $this->seed($reglage);
    }

    public function seed($reglage)
    {
        $faker = Faker\Factory::create('fr_FR');
        $date = date("Y-m-d H:i:s", $faker->unixTime('now'));
        $data = [
            [
                $reglage => "opérations exonérées de TVA",
                "Pourcentage" => "0",
                "note" => "Certaines opérations sont exonérées de TVA. Découvrez les secteurs d'activités et les opérations concernées par cette exonération.",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "TVA normal 20 % ",
                "Pourcentage" => "20",
                "note" => "La taxe sur la valeur ajoutée ou TVA est un impôt indirect sur la consommation.",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ]];

        $this->table($reglage)->insert($data)->save();
    }
}
