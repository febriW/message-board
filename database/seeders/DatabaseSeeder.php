<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(300)->create();
        $users = \App\Models\User::all();
        $users->each(function ($user) {
            \App\Models\Message::factory()->create(['user_id' => $user->id]);
        });
    }
}