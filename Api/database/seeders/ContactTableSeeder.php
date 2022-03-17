<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactTableSeeder extends Seeder
{
    private $faker;
    private $contacts;

    function __construct() {
        $this->faker = \Faker\Factory::create('pt_BR');
        $this->contacts = 5;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($index = 0; $index < $this->contacts; $index++) {
            Contact::create([
                'name' => '', 
            'phone' => $this->faker->numerify('(##) #####-####'), 
            'cpf' => $this->faker->cpf, 
            'address' => $this->address()->streetAddress, 
            'number' => $this->address()->buildingNumber, 
            'neighborhood' =>$this->address()->streetName, 
            'city' => $this->address()->city, 
            'state' => $this->address()->state, 
            'cep' => $this->address()->postcode, 
            'latitude' => $this->address()->latitude, 
            'longitude' => $this->address()->longitude,
            'type_id' => 1
            ]);
        }       
    }
}
