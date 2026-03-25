<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Andres',
            'email' => 'admin@admin.com',
        ]);
        User::factory()->create([
            'name' => 'Regular',
            'email' => 'regular@regular.com',
        ]);
        //   $this->call(CategorySeeder::class);

        Category::factory(10)->create();
        Post::factory(30)->create();
    }
}
