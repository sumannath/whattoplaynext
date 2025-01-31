<?php

namespace Database\Seeders;

use App\Models\User;
use App\Jobs\ProcessIGDBData;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GenreSeeder::class,
            //CompanySeeder::class,
            CategorySeeder::class,
            PlatformSeeder::class,
            PerspectiveSeeder::class,
            ThemeSeeder::class,
            //GameSeeder::class,
        ]);

        ProcessIGDBData::dispatch();
    }
}
