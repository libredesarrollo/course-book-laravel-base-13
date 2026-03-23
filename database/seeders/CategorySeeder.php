<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // USAR FACTORY
        // for ($i=0; $i < 20; $i++) { 
        //     Category::create([
        //         'title' => 'S Cate'.$i,
        //         'slug' => 's-cate-'.$i
        //     ]);
        // }

        Category::factory(10)->create();
    }
}
