<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\People;
use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PeopleTest extends TestCase
{
    use WithFaker, WithoutMiddleware;
    

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_return_200_for_people_route()
    {
        $response = $this->get('/api/people');
        $response->assertStatus(200);
    }

    public function test_should_return_four_objects_for_people_route()
    {
        People::factory()->count(4)->create([
            'name' => $this->faker->name
        ]);
        $response = $this->get('/api/people');
        $response->assertJsonCount(4, 'data');
    }

    
}