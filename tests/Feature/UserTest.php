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
        $user = User::factory()->make();

        $this->postJson($this->path, $user->toArray())
            ->assertCreated();
        
        $this->assertDatabaseHas('users', ['name' => $user->name]);
    }

    public function test_create_same_email_user(){
        $user = User::factory()->make();

        $this->postJson($this->path, $user->toArray());
        
        $this->postJson($this->path, $user->toArray())
            ->assertConflict();
    }
}
