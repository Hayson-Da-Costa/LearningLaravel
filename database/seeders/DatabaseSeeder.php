<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        /** Easy way to do  */
        // $this->call(PostsTableSeeder::class);
        
        Post::factory(100)->create();
        
        /** Overriding the properties of our Model Factory */
        // Post::factory(100)->create([
        //     'body' => 'Overriding the body of our post'
        // ]);

    }
}
