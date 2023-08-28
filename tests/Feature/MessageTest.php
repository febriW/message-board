<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Message;
use App\Models\User;

class MessageTest extends TestCase
{

    use RefreshDatabase;
    private $path = '/api/message';

    /**
     * A basic feature test example.
     */
    public function test_get_message(): void
    {
        Message::factory()->count(5)->make();
        $this->get($this->path)
            ->assertOk();
    }

    public function test_create_message(){
        $message = Message::factory()->create();
        $this->postJson($this->path, $message->toArray())
            ->assertCreated();
    }

    public function test_create_message_not_validated()
    {
        $message = [
            'user_id' => '2',
            'message' => fake()->text(300),
        ];

        $this->postJson($this->path, $message)
            ->assertUnprocessable();
    }
    
    public function test_search_message(){
        $user =  User::factory()->create([
            'name' => 'User Test',
            'email' => 'usertest@example.com',
        ]);
        $message = Message::factory()->create([
            'user_id' => $user->id,
            'message' => fake()->text(200),
        ]);

        $this->postJson($this->path .'/'. 'search',[
            "params" => $message->message
        ])->assertOk();

        $this->postJson($this->path .'/'. 'search',[
            "params" => $user->email
        ])->assertOk();

        $this->postJson($this->path .'/'. 'search',[
            "params" => $user->name
        ])->assertOk();
    }

    public function test_search_message_not_validated(){
        $this->postJson($this->path .'/'. 'search')
            ->assertUnprocessable();
    }

    public function test_update_message(){
        $user =  User::factory()->create([
            'name' => 'User Test',
            'email' => 'usertest@example.com',
        ]);

        $message = Message::factory()->create([
            'user_id' => $user->id,
            'message' => fake()->text(200),
        ]);
        $this->patchJson($this->path .'/'. $message->id, ['message' => $message->message])
            ->assertOk();
    }

    public function test_message_delete(){
        $user =  User::factory()->create([
            'name' => 'User Test',
            'email' => 'usertest@example.com',
        ]);

        $message = Message::factory()->create([
            'user_id' => $user->id,
            'message' => fake()->text(200),
        ]);

        $this->delete($this->path .'/'. $message->id)
            ->assertNoContent($status = 204);
    }
}
