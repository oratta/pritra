<?php

use Illuminate\Database\Seeder;

class MenuMastersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_masters')->truncate();
        DB::table('menu_masters')->insert([
            [
                'id'    => 1,
                'name'  => 'Push up',
                'description' => '',
            ],
            [
                'id'    => 2,
                'name'  => 'Squat',
                'description' => '',
            ],
            [
                'id'    => 3,
                'name'  => 'Pull up',
                'description' => '',
            ],
            [
                'id'    => 4,
                'name'  => 'Leg Raise',
                'description' => '',
            ],
            [
                'id'    => 5,
                'name'  => 'Bridge',
                'description' => '',
            ],
            [
                'id'    => 6,
                'name'  => 'Hand Stand Push up',
                'description' => '',
            ],
        ]);
    }
}
