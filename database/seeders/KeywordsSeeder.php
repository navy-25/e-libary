<?php

namespace Database\Seeders;

use App\Models\Keywords;
use Illuminate\Database\Seeder;

class KeywordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Keywords::create(['name' => 'Kemanusiaan']);
        Keywords::create(['name' => 'Umum']);
        Keywords::create(['name' => 'Flora']);
        Keywords::create(['name' => 'Fauna']);
        Keywords::create(['name' => 'Level pemula']);
        Keywords::create(['name' => 'Level menengah']);
    }
}
