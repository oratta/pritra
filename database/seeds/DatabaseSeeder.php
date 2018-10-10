<?php

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
        $this->call([
            MenuMastersTableSeeder::class,
            StepMastersTableSeeder::class,
            UsersTableSeeder::class,
            WorkoutsTableSeeder::class,
        ]);
    }
}
