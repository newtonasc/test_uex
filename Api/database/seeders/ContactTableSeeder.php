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
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
            'name' => $this->faker->name, 
            'phone' => $this->faker->numerify('(##) #####-####'), 
            'cpf' => $this->faker->cpf, 
            'address' => 'Av. Rio Branco', 
            'number' => '1', 
            'neighborhood' => 'Centro', 
            'city' => 'Rio de Janeiro', 
            'state' => 'Rio de Janeiro', 
            'cep' => '20090-003', 
            'latitude' => '-22.89714753262386', 
            'longitude' => '-43.18026747323982',
            'type_id' => 1
        ]);     
        Contact::create([
            'name' => $this->faker->name, 
            'phone' => $this->faker->numerify('(##) #####-####'), 
            'cpf' => $this->faker->cpf, 
            'address' => 'Av. Dr. Altino Arantes', 
            'number' => '544', 
            'neighborhood' => 'Centro', 
            'city' => 'São Sebastião', 
            'state' => 'São Paulo', 
            'cep' => '11600-000', 
            'latitude' => '-23.8060406287278', 
            'longitude' => '-45.400604359732405',
            'type_id' => 2
        ]);   
        Contact::create([
            'name' => $this->faker->name, 
            'phone' => $this->faker->numerify('(##) #####-####'), 
            'cpf' => $this->faker->cpf, 
            'address' => 'Av. Mal. Floriano Peixoto', 
            'number' => '1000', 
            'neighborhood' => 'Alto Boqueirão', 
            'city' => 'Curitiba', 
            'state' => 'Paraná', 
            'cep' => '80230-110', 
            'latitude' => '-25.438353256327588', 
            'longitude' => '-49.26840147376986',
            'type_id' => 2
        ]);
    }
}
