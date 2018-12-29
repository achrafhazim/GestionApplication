<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class Marques extends AbstractMigration
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

        $this->table("marques", HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master('marques'))
                ->addColumn(HTML_Phinx::textarea('note'))
                ->addColumn(HTML_Phinx::text('site$web'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->create();

//////////////////////////////////////////////////////////////////////////////////////
                $faker = Faker\Factory::create('fr_FR');
                $date = date("Y-m-d H:i:s", $faker->unixTime('now'));
                $data = [
                    [
                        'marques' => "dell",

                        "note" => "Certaines opérations sont exonérées de TVA. Découvrez les secteurs d'activités et les opérations concernées par cette exonération.",
                        "date_ajoute" => $date,
                        "date_modifier" => $date
                    ], [
                        'marques' => "hp",

                        "note" => "La taxe sur la valeur ajoutée ou TVA est un impôt indirect sur la consommation.",
                        "date_ajoute" => $date,
                        "date_modifier" => $date
                    ]];

                $this->table("marques")->insert($data)->save();
    }
}
