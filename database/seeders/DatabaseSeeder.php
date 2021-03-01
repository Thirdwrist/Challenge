<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ApplicationSeeder::class);
    }
}
