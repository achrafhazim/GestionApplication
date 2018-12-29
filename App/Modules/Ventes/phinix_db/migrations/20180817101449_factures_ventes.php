<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class FacturesVentes extends AbstractMigration
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

          CREATE TABLE `factures$ventes` (
          `id` int(10) NOT NULL,
          `clients` int(11) NOT NULL,
          `N` varchar(200) NOT NULL,
          `date` date NOT NULL,
          `titre` varchar(200) NOT NULL,
          `montant_HT` double NOT NULL,
          `montant_TVA` double NOT NULL,
          `montant_TTC` double NOT NULL,
          `fichiers` varchar(250) DEFAULT NULL,
          `date_ajoute` datetime NOT NULL,
          `date_modifier` datetime NOT NULL,
          `remarque` text DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         */

        $this->table('factures$ventes', HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::select('clients'))
                ->addColumn(HTML_Phinx::text_master('N'))
                ->addColumn(HTML_Phinx::date())
                ->addColumn(HTML_Phinx::text_master('titre'))
                ->addColumn(HTML_Phinx::number('montant_HT'))
                ->addColumn(HTML_Phinx::number('montant_TVA'))
                ->addColumn(HTML_Phinx::number('montant_TTC'))
                ->addColumn(HTML_Phinx::textarea('remarque'))
                ->addColumn(HTML_Phinx::file('fichiers'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addForeignKey('clients', 'clients', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();


        /*
          --
          -- Structure de la table `r_factures$ventes_devis`
          --

          CREATE TABLE `r_factures$ventes_devis` (
          `id_factures$ventes` int(11) NOT NULL,
          `id_devis` int(11) NOT NULL,
          `remarque` text DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         */
        HTML_Phinx::relation('factures$ventes', 'devis', $this->getAdapter());
    }
}
