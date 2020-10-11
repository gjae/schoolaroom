<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $developerSeeders = [
        PeriodSeeder::class,
        DegreeSeeder::class,
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment('local')) {
            collect($this->developerSeeders)->each(fn($seed) => $this->call($seed));
        }
    }
}
