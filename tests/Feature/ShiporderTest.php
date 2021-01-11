<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\People;
use App\Models\Shiporder;

class ShiporderTest extends TestCase
{
    use WithFaker, DatabaseMigrations, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_return_200_for_shiporder_route()
    {
        $response = $this->get('/api/people');
        $response->assertStatus(200);
    }

    public function test_should_return_one_object_for_shiporder_route()
    {
        $people = People::factory()->count(1)->create([
            'id' => 1,
            'name' => $this->faker->name
        ]);
        Shiporder::factory()->count(1)->create([
            'people_id' => $people[0]->id,
            'shipto_name' => $this->faker->name,
            'shipto_address' =>$this->faker->streetName,
            'shipto_city' => $this->faker->city,
            'shipto_country' => $this->faker->country,
        ]);
        $response = $this->get('/api/shiporder');
        $response->assertJsonCount(1, 'data');
    }
}
