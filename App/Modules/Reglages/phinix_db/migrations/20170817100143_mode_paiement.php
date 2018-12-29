<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class ModePaiement extends AbstractMigration
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
          CREATE TABLE `mode$paiement` (
          `id` int(10) NOT NULL,
          `mode$paiement` varchar(200) NOT NULL,
          `date_ajoute` datetime NOT NULL,
          `date_modifier` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         */
        $reglage = 'mode$paiement';
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
        $data = [[
        $reglage => "Chèque",
        "note" => "Écrit par lequel une personne (tireur) donne l'ordre de remettre, soit à son profit, soit au profit d'un tiers, une somme à prélever sur le crédit (de son compte ou d'un autre)",
        "date_ajoute" => $date,
        "date_modifier" => $date
            ], [
                $reglage => "Espèces",
                "note" => "Payer un commerçant ou artisan en argent liquide.",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Carte bancaire",
                "note" => "Les cartes bancaires sont organisées en gammes (Classique, Gold/Premier, Infinite, Platinum...). Les différences entre ces cartes sont de 3 ordres : Les capacités de paiements ou de retraits : plus la carte est haut de gamme, plus vous pourrez effectuer des montants de retraits ou de paiement élevés.",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Virement bancaire",
                "note" => "Le virement bancaire est un moyen simple de transférer de l'argent de compte à compte. Un compte bancaire est soumis à une convention qui détermine les conditions de son utilisation. Toutes les informations suivantes tiennent compte des usages habituels des banques, ils peuvent être néanmoins différents dans certains organismes, notamment en ce qui concerne les frais afférents aux virements bancaires.",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "Prélèvement",
                "note" => "Le prélèvement bancaire, établi habituellement sous forme de prélèvement automatique, est un transfert de fonds répétitif (souvent exercé de façon périodique, mensuelle par exemple) ou ponctuel par l'intermédiaire du système bancaire, utilisé surtout au niveau domestique.",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                $reglage => "effet bancaire",
                "note" => "L'escompte est le mécanisme par lequel un établissement de crédit (une banque généralement) rachète à un bénéficiaire les effets de commerce dont il est porteur. Le bénéficiaire qui cède ainsi ses effets est appelé le cédant, le débiteur est appelé le cédé. Le banquier devient alors le créancier du cédé.",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ]];

        $this->table($reglage)->insert($data)->save();
    }
}
