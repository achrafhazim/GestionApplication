<?php

use Phinx\Migration\AbstractMigration;
use Kernel\Conevert\HTML_Phinx;

class Contacts extends AbstractMigration
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
          CREATE TABLE `contacts` (
          `id` int(10) NOT NULL,
          `raison$sociale` int(11) NOT NULL,
          `Prenom` varchar(201) NOT NULL,
          `Nom` varchar(201) NOT NULL,
          `TELE` varchar(20) NOT NULL,
          `GSM` varchar(20) DEFAULT NULL,
          `Fonction` varchar(201) DEFAULT NULL,
          `Email` varchar(150) DEFAULT NULL,
          `date_ajoute` datetime NOT NULL,
          `date_modifier` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

         */
        $this->table("contacts", HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::select('raison$sociale'))
                ->addColumn(HTML_Phinx::text_master('Prenom'))
                ->addColumn(HTML_Phinx::text_master('Nom'))
                ->addColumn(HTML_Phinx::tel())
                ->addColumn(HTML_Phinx::tel('GSM'))
                ->addColumn(HTML_Phinx::text('Fonction'))
                ->addColumn(HTML_Phinx::email())
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addForeignKey('raison$sociale', 'raison$sociale', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();
    }
}
