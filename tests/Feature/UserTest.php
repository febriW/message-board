<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    protected $path = '/api/user';
    /**
     * A basic feature test example.
     */
    public function test_list_users()
    {
        $user = User::factory()->count(5)->create();

        $response = $this->get($this->path);
        $response->assertOk();
        $response->assertJsonCount(5);
    }

    public function test_create_user() {
        $user = [
            "name" => "2",
            "email" => "test@test.com"
        ];

        $this->postJson($this->path, $user)
            ->assertCreated();
        
        $this->assertDatabaseHas('users', ['name' => $user['name']]);
    }

    public function test_not_valid_input()
    {
        $user = [
            "name" => 2,
            "email" => "test@test.com"
        ];

        $this->postJson($this->path, $user)
            ->assertUnprocessable();
    }

    public function test_not_valid_email()
    {
        $user = [
            "name" => "Testing",
            "email" => "test@test.jp"
        ];

        $this->postJson($this->path, $user)
            ->assertUnprocessable();
    }
}
