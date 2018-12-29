<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class TypesProduit extends AbstractMigration
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
        $reglage = 'type$produit';
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
        $reglage => "packs",
        "note" => "Vous pourriez souhaiter vendre un pack de produits composé de plusieurs articles.  ",
        "date_ajoute" => $date,
        "date_modifier" => $date
                  ],
                  [
                  $reglage => "articles",
                  "note" => "Les produits (biens) sont classés : selon le type de clientèle, la fréquence d'achat, la durée d'utilisation ou selon le lien qu'ils entretiennent avec d'autres produits. ",
                  "date_ajoute" => $date,
                  "date_modifier" => $date
                  ],       [
                  $reglage => "Service",
                  "note" => "Distinction biens / services. Un bien matériel est tangible, on peut le toucher, le voir. Un service est une \"aide\" donnée à une autre personne en échange de quelque chose. Un bien matériel est un objet que l'on peut acheter.",
                  "date_ajoute" => $date,
                  "date_modifier" => $date
                  ],       [
                  $reglage => "Ouvrage",
                  "note" => "travail",
                  "date_ajoute" => $date,
                  "date_modifier" => $date
                  ],       [
                  $reglage => "Composant",
                  "note" => "lément qui entre dans la composition de qqch",
                  "date_ajoute" => $date,
                  "date_modifier" => $date
                  ]
                ];

                $this->table($reglage)->insert($data)->save();
    }
}
