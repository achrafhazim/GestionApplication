<?php

use Phinx\Migration\AbstractMigration;
use Kernel\Conevert\HTML_Phinx;

class RaisonSociale extends AbstractMigration
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
          CREATE TABLE `raison$sociale` (
          `id` int(10) NOT NULL,
          `raison$sociale` varchar(200) NOT NULL,
          `ICE` varchar(200) NOT NULL,
          `I_F` varchar(201) NOT NULL,
          `T_P` varchar(201) NOT NULL,
          `R_C` varchar(201) NOT NULL,
          `CNSS` varchar(200) NOT NULL,
          `TELE1` varchar(20) NOT NULL,
          `TELE2` varchar(20) DEFAULT NULL,
          `GSM` varchar(20) DEFAULT NULL,
          `FAX` varchar(20) DEFAULT NULL,
          `site_web` varchar(200) DEFAULT NULL,
          `EMAIL` varchar(150) DEFAULT NULL,
          `adresse` text DEFAULT NULL,
          `fichiers` varchar(250) DEFAULT NULL,
          `date_ajoute` datetime NOT NULL,
          `date_modifier` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



          ALTER TABLE `raison$sociale`
          ADD PRIMARY KEY (`id`),
          ADD UNIQUE KEY `RAISON_SOCIALE` (`raison$sociale`),
          ADD UNIQUE KEY `ICE` (`ICE`),
          ADD UNIQUE KEY `I-F` (`I_F`),
          ADD UNIQUE KEY `CNSS` (`CNSS`),
          ADD UNIQUE KEY `T-P` (`T_P`),
          ADD UNIQUE KEY `R-C` (`R_C`);


          ALTER TABLE `raison$sociale`
          MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
         */


        $this->table('raison$sociale', HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master('raison$sociale'))
                ->addColumn(HTML_Phinx::text_master('ICE'))
                ->addColumn(HTML_Phinx::text_master('I_F'))
                ->addColumn(HTML_Phinx::text_master('T_P'))
                ->addColumn(HTML_Phinx::text_master('R_C'))
                ->addColumn(HTML_Phinx::text_master('CNSS'))
                ->addColumn(HTML_Phinx::tel('TEL'))
                ->addColumn(HTML_Phinx::tel('GSM'))
                ->addColumn(HTML_Phinx::tel('FAX'))
                ->addColumn(HTML_Phinx::text('site_web'))
                ->addColumn(HTML_Phinx::email())
                ->addColumn(HTML_Phinx::textarea('adresse'))
                ->addColumn(HTML_Phinx::file())
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addIndex(['ICE'], ['unique' => true])
                ->addIndex(['I_F'], ['unique' => true])
                ->addIndex(['T_P'], ['unique' => true])
                ->addIndex(['R_C'], ['unique' => true])
                ->addIndex(['CNSS'], ['unique' => true])
                ->create();
    }
}
