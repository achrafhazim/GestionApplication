<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class Articles extends AbstractMigration
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

        $this->table("articles", HTML_Phinx::id_default())

                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::select('type$produit'))
                ->addColumn(HTML_Phinx::text_master('articles'))
                ->addColumn(HTML_Phinx::select('taxes'))
                ->addColumn(HTML_Phinx::select('marques'))

                ->addColumn(HTML_Phinx::select('familles$des$articles'))
                ->addColumn(HTML_Phinx::select('unites'))
                ->addColumn(HTML_Phinx::textarea('Description'))
                ->addColumn(HTML_Phinx::number('Prix$d$achat$HT'))
                ->addColumn(HTML_Phinx::number('Prix$de$vente$HT'))
                ->addColumn(HTML_Phinx::checkBox('Disponible$dans$les$ventes'))
                ->addColumn(HTML_Phinx::checkBox('Disponible$dans$les$achats'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addForeignKey('taxes', 'taxes', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->addForeignKey('marques', 'marques', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->addForeignKey('type$produit', 'type$produit', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->addForeignKey('familles$des$articles', 'familles$des$articles', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->addForeignKey('unites', 'unites', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();


                $faker = Faker\Factory::create('fr_FR');
                $date = date("Y-m-d H:i:s", $faker->unixTime('now'));
                $data = [
                    [
                        'articles' => "produit1",
                        'type$produit' => "1",
                        'taxes' => "1",
                         'marques'=> "1",
                        'familles$des$articles' => "1",
                        'unites' => "5",
                        'Prix$d$achat$HT' => "100",
                        'Prix$de$vente$HT' => "200",
                        'Disponible$dans$les$ventes' => "1",
                        'Disponible$dans$les$achats' => "1",
                        "date_ajoute" => $date,
                        "date_modifier" => $date
                    ], [
                      'articles' => "produit2",
                      'type$produit' => "2",
                      'taxes' => "1",
                       'marques'=> "2",
                      'familles$des$articles' => "2",
                      'unites' => "3",
                      'Prix$d$achat$HT' => "500",
                      'Prix$de$vente$HT' => "600",
                      'Disponible$dans$les$ventes' => "1",
                      'Disponible$dans$les$achats' => "0",
                      "date_ajoute" => $date,
                      "date_modifier" => $date

                    ], [
                      'articles' => "produit3",
                      'type$produit' => "1",
                      'taxes' => "1",
                       'marques'=> "1",
                      'familles$des$articles' => "1",
                      'unites' => "1",
                      'Prix$d$achat$HT' => "700",
                      'Prix$de$vente$HT' => "100",
                      'Disponible$dans$les$ventes' => "0",
                      'Disponible$dans$les$achats' => "1",
                      "date_ajoute" => $date,
                      "date_modifier" => $date

                    ], [
                      'articles' => "produit4",
                      'type$produit' => "1",
                      'taxes' => "1",
                       'marques'=> "1",
                      'familles$des$articles' => "1",
                      'unites' => "1",
                      'Prix$d$achat$HT' => "200",
                      'Prix$de$vente$HT' => "400",
                      'Disponible$dans$les$ventes' => "1",
                      'Disponible$dans$les$achats' => "1",
                      "date_ajoute" => $date,
                      "date_modifier" => $date

                    ]];

                $this->table('articles')->insert($data)->save();
    }
}
