<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class Commandes extends AbstractMigration
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
        /*
          CREATE TABLE `commandes` (
          `id` int(10) NOT NULL,
          `fournisseur` int(11) NOT NULL,
          `titre` varchar(200) NOT NULL,
          `date` date NOT NULL,
          `montant_estime_HT` double NOT NULL,
          `adresse` text DEFAULT NULL,
          `remarque` text DEFAULT NULL,
          `fichiers` varchar(250) DEFAULT NULL,
          `date_ajoute` datetime NOT NULL,
          `date_modifier` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

         */

        $this->table("commandes", HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::select('fournisseur'))
                ->addColumn(HTML_Phinx::text_master('titre'))
                ->addColumn(HTML_Phinx::number('montant_estime_HT'))
                ->addColumn(HTML_Phinx::textarea('adresse'))
                ->addColumn(HTML_Phinx::textarea('remarque'))
                ->addColumn(HTML_Phinx::file('fichiers'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addForeignKey('fournisseur', 'fournisseur', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();
             HTML_Phinx::relationList('commandes', 'articles', $this->getAdapter());
             
    }
}
