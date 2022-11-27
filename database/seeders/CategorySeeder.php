<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Saintek']);
        Category::create(['name' => 'Soshum']);
        Category::create(['name' => 'Politik']);
        Category::create(['name' => 'Agama Islam']);
    }
}
