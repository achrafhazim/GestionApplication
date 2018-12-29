<?php

use Phinx\Seed\AbstractSeed;

class RaisonSociale extends AbstractSeed
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
        for ($index = 0; $index < 30; $index++) {
            $date = date("Y-m-d H:i:s", $faker->unixTime('now'));
            $data[] = [
                'raison$sociale' => $faker->name(),
                'ICE' => $faker->uuid,
                'I_F' => $faker->uuid,
                'T_P' => $faker->uuid,
                'R_C' => $faker->uuid,
                'CNSS' => $faker->uuid,
                "TEL" => $faker->phoneNumber,
                "GSM" => $faker->phoneNumber,
                "FAX" => $faker->phoneNumber,
                'site_web' =>"www". $faker->name().".com",
                "email" => $faker->email,
                "adresse" => $faker->address,
               
                "date_ajoute" => $date,
                "date_modifier" => $date
            ];
        }
        $this->table('raison$sociale')->insert($data)->save();
    }
}
