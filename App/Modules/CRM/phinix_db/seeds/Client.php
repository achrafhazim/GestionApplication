<?php

use Phinx\Seed\AbstractSeed;

class Client extends AbstractSeed
{

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [];
        $faker = Faker\Factory::create('fr_FR');
        for ($index = 0; $index < 1000; $index++) {
            $date = date("Y-m-d H:i:s", $faker->unixTime('now'));
            $data[] = [
                "clients" => $faker->name(),
                'cin' => $faker->uuid,
                "TEL" => $faker->phoneNumber,
                "adresse" => $faker->address,
                "commentaires_remarque" => $faker->text(30),
                "date_ajoute" => $date,
                "date_modifier" => $date
            ];
        }
        $this->table("clients")->insert($data)->save();
    }
}
