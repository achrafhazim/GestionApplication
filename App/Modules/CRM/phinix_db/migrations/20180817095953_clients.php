<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class Clients extends AbstractMigration
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
          CREATE TABLE `clients` (
          `id` int(10) NOT NULL,
          `clients` varchar(200) NOT NULL,
          `cin` varchar(200) NOT NULL,
          `telephone` varchar(20) DEFAULT NULL,
          `adresse` text DEFAULT NULL,
          `fichiers` varchar(250) DEFAULT NULL,
          `commentaires_remarque` text DEFAULT NULL,
          `date_ajoute` datetime NOT NULL,
          `date_modifier` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


          ALTER TABLE `clients`
          ADD PRIMARY KEY (`id`),
          ADD UNIQUE KEY `cin` (`cin`);


          ALTER TABLE `clients`
          MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
         */
        $this->table("clients", HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master('clients'))
                ->addColumn(HTML_Phinx::text_master('cin'))
                ->addColumn(HTML_Phinx::tel())
                ->addColumn(HTML_Phinx::textarea("adresse"))
                ->addColumn(HTML_Phinx::file())
                ->addColumn(HTML_Phinx::textarea("commentaires_remarque"))
               
                
                
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addIndex(['cin'], ['unique' => true])
                ->create();
    }
}
