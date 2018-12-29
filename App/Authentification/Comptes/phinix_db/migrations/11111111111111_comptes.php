<?php

use Faker\Factory;
use Kernel\AWA_Interface\PasswordInterface;
use Kernel\Conevert\HTML_Phinx;
use Kernel\Container\Factory_Container;
use Phinx\Migration\AbstractMigration;

class Comptes extends AbstractMigration
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
   
    /**
     * Migrate Up.
     */
    public function up()
    {
             $this->table("comptes", HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master('comptes'))
                ->addColumn(HTML_Phinx::text_master('login'))
                ->addColumn(HTML_Phinx::email_master())
                ->addColumn(HTML_Phinx::password())
                ->addColumn(HTML_Phinx::checkBox("active"))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addIndex(['login'], ['unique' => true])
                ->addIndex(['comptes'], ['unique' => true])
                ->addIndex(['email'], ['unique' => true])
                ->create();
        $faker = Factory::create('fr_FR');
        //singltone ==>dejat set $pathconfig
        $container= Factory_Container::getContainer();
        
        $password=$container->get(PasswordInterface::class);
        $date = date("Y-m-d H:i:s", $faker->unixTime('now'));
        $data = ["comptes" => "root",
            "login" => "root",
            "email" => "root@root.root",
            "active" => 1,
            "password" =>$password->encrypt("root"),
            "date_ajoute" => $date,
            "date_modifier" => $date];
        $this->table("comptes")->insert($data)->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('comptes')->drop()->save();
    }
}
