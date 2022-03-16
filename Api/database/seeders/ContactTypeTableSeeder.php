<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactTypes;

class ContactTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Cliente', 'Parceiro', 'Fornecedor'];
        foreach ($types as $value) {
            ContactTypes::create(['name' => $value]);
        }       
    }
}
