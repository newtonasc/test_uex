<?php

namespace Tests\Unit;

use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;

/**
 * Class ContactControllerTest
 * @package tests\Unit\Http\Controllers
 * @group uex
 */
class ContactControllerTest extends TestCase {
    private $faker;
    protected function setUp(): void {
        parent::setUp();
        $this->faker = \Faker\Factory::create('pt_BR');
    }
    
    public function testIndex() {        
        $result = $this->get('/api/contacts');
        $this->assertEquals(200, $result->status());
    }

    public function testSearch() {
        $data = $this->mockData();
        $fakeName = $this->faker->name;
        $data['name'] = $fakeName;
        // Create dataset
        $store = $this->post('/api/contacts', $data);
        $this->assertTrue($store->getData()->success);
        $this->assertEquals(200, $store->status());
        $this->assertEquals($store->getData()->data->name, $fakeName);
        $contactId = $store->getData()->data->id;
        // Test search success        
        $result = $this->post('/api/contacts/search', ['term' => $fakeName]);
        $this->assertEquals(200, $result->status());
        // Clean dataset
        $delete = $this->delete('/api/contacts/'.$contactId);
        $this->assertTrue($delete->getData()->success);
        $this->assertEquals(200, $delete->status());
    }

    public function testFilter() {
        $data = $this->mockData();
        $fakeName = $this->faker->name;
        $data['name'] = $fakeName;
        // Create dataset
        $store = $this->post('/api/contacts', $data);
        $this->assertTrue($store->getData()->success);
        $this->assertEquals(200, $store->status());
        $this->assertEquals($store->getData()->data->name, $fakeName);
        $contactId = $store->getData()->data->id;
        // Test filter success        
        $result = $this->post('/api/contacts/filter', ['filter' => 1]);
        $this->assertEquals(200, $result->status());
        // Clean dataset
        $delete = $this->delete('/api/contacts/'.$contactId);
        $this->assertTrue($delete->getData()->success);
        $this->assertEquals(200, $delete->status());
    }

    public function testStore() {
        $data = $this->mockData();
        // Test store validate empty field error
        $data['name'] = '';
        $store = $this->post('/api/contacts', $data);
        $this->assertFalse($store->getData()->success);
        $this->assertEquals(404, $store->status());
        $this->assertEquals($store->getData()->message->name[0], 'The name field is required.');
        // Test store success
        $fakeName = $this->faker->name;
        $data['name'] = $fakeName;
        $store = $this->post('/api/contacts', $data);        
        $this->assertTrue($store->getData()->success);
        $this->assertEquals(200, $store->status());
        $this->assertEquals($store->getData()->data->name, $fakeName);
        // Test store validate duplicated cpf field error
        $contactId = $store->getData()->data->id;        
        $store = $this->post('/api/contacts', $data);
        $this->assertFalse($store->getData()->success);
        $this->assertEquals(404, $store->status());
        $this->assertEquals($store->getData()->message->cpf[0], 'The cpf has already been taken.');
        // Clean dataset
        $delete = $this->delete('/api/contacts/'.$contactId);
        $this->assertTrue($delete->getData()->success);
        $this->assertEquals(200, $delete->status());        
    }

    public function testUpdate() {
        $data = $this->mockData();
        $fakeName = $this->faker->name;
        $data['name'] = $fakeName;
        // Create dataset
        $store = $this->post('/api/contacts', $data);
        $this->assertTrue($store->getData()->success);
        $this->assertEquals(200, $store->status());
        $this->assertEquals($store->getData()->data->name, $fakeName);
        $contactId = $store->getData()->data->id;
        // Test update success
        $fakeName = $this->faker->name;
        $data['name'] = $fakeName;
        $update = $this->put('/api/contacts/'.$contactId, $data);
        $this->assertEquals(200, $update->status());
        $this->assertEquals($update->getData()->data->name, $fakeName);
        // Test update error
        $data['name'] = '';
        $update = $this->put('/api/contacts/'.$contactId, $data);
        $this->assertEquals(404, $update->status());
        // Clean dataset
        $delete = $this->delete('/api/contacts/'.$contactId);
        $this->assertTrue($delete->getData()->success);
        $this->assertEquals(200, $delete->status());
    }
    
    public function testDestroy() {
        $data = $this->mockData();
        $fakeName = $this->faker->name;
        $data['name'] = $fakeName;
        // Create dataset
        $store = $this->post('/api/contacts', $data);
        $this->assertTrue($store->getData()->success);
        $this->assertEquals(200, $store->status());
        $this->assertEquals($store->getData()->data->name, $fakeName);
        $contactId = $store->getData()->data->id;        
        // Test delete success
        $delete = $this->delete('/api/contacts/'.$contactId);
        $this->assertTrue($delete->getData()->success);
        $this->assertEquals(200, $delete->status());
    }

    private function mockData() {
        return [
            'name' => '', 
            'phone' => $this->faker->numerify('(##) #####-####'), 
            'cpf' => $this->faker->cpf, 
            'address' => 'Rua Brigadeiro Franco', 
            'number' => '2406', 
            'neighborhood' => 'Água verde', 
            'city' => 'Curitiba', 
            'state' => 'Paraná', 
            'cep' => '80250042', 
            'latitude' => '-25.4492997', 
            'longitude' => '-49.2728488',
            'type_id' => 1
        ];
    }
}