<?php

use Phinx\Migration\AbstractMigration;
use Kernel\Conevert\HTML_Phinx;

class BonsAchats extends AbstractMigration
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

        /**
          CREATE TABLE `bons$achats` (
          `id` int(10) NOT NULL,
          `raison$sociale` int(11) NOT NULL,
          `N` varchar(200) NOT NULL,
          `date` date NOT NULL,
          `montant_HT` double NOT NULL,
          `montant_TVA` double NOT NULL,
          `montant_TTC` double NOT NULL,
          `adresse` text DEFAULT NULL,
          `remarque` text DEFAULT NULL,
          `fichiers` varchar(250) DEFAULT NULL,
          `date_ajoute` datetime NOT NULL,
          `date_modifier` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         */
        $this->table('bons$achats', HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::select('raison$sociale'))
                ->addColumn(HTML_Phinx::text_master('N'))
                ->addColumn(HTML_Phinx::date('date'))
                ->addColumn(HTML_Phinx::number('montant_HT'))
                ->addColumn(HTML_Phinx::number('montant_TVA'))
                ->addColumn(HTML_Phinx::number('montant_TTC'))
                ->addColumn(HTML_Phinx::textarea('remarque'))
                ->addColumn(HTML_Phinx::textarea('adresse'))
                ->addColumn(HTML_Phinx::file('fichiers'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addForeignKey('raison$sociale', 'raison$sociale', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();
                HTML_Phinx::relation('bons$achats', 'list$articles', $this->getAdapter());

        /**
          --
          -- Structure de la table `r_bons$achats_commandes`
          --
          CREATE TABLE `r_bons$achats_commandes` (
          `id_bons$achats` int(10) NOT NULL,
          `id_commandes` int(10) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


          ALTER TABLE `r_bons$achats_commandes`
          ADD PRIMARY KEY (`id_bons$achats`,`id_commandes`),
          ADD KEY `id_commandes` (`id_commandes`);


          ALTER TABLE `r_bons$achats_commandes`
          ADD CONSTRAINT `r_bons$achats_commandes_ibfk_1` FOREIGN KEY (`id_bons$achats`) REFERENCES `bons$achats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          ADD CONSTRAINT `r_bons$achats_commandes_ibfk_2` FOREIGN KEY (`id_commandes`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         */

        HTML_Phinx::relation('bons$achats', 'commandes', $this->getAdapter());
    }
}
