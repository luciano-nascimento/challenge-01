<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_retrieve_login()
    {
        User::factory()->create(
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => \Hash::make('12345678')
            ]
        );

        $body = [
            'email' => 'admin@admin.com',
            'password' => '12345678'
        ];
        $this->json('POST','/api/auth/login',$body)
            ->assertStatus(200)
            ->assertJsonFragment(['token_type' => 'bearer']);
    }
}
