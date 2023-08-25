<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use app\Models\Message;

class MessageTest extends TestCase
{

    private $path = '/api/message';

    /**
     * A basic feature test example.
     */
    public function test_get_message(): void
    {
        Message::factory()->count(32)->make();
        $this->get($this->path)
            ->assertOk();
    }

    public function test_create_message(){
        $message = Message::factory()->create();
        $this->postJson($this->path, $person)
            ->assertCreated();
    }
    
    public function test_search_message(){
        $message = Message::factory()->create();
        $this->postJson($this->path, $person)
            ->assertOk();
    }
}
