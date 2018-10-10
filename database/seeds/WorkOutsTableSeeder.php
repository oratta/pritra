<?php

use Illuminate\Database\Seeder;

class WorkoutsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_outs')->insert([
            [
                'user_id'  => 1,
                'menu_master_id' => 1,
                'step_master_id' => 1,
                'count' => 20,
                'difficulty_type' => 1,
                'created_at' => '2018-10-05 19:17:28'
            ],
            [
                'user_id'  => 1,
                'menu_master_id' => 1,
                'step_master_id' => 1,
                'count' => 20,
                'difficulty_type' => 1,
                'created_at' => '2018-10-05 19:20:28'
            ],
        ]);
    }
}
