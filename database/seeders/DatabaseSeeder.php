<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->call([
            BookSeeder::class,
            CategorySeeder::class,
            KeywordsSeeder::class,
        ]);
    }
}
