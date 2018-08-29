<?php

use Illuminate\Database\Seeder;

class StepsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('steps')->insert([
            [
                'menu_id' => 1,
                'step_number' => 1,
                'name' => "ウォール・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 25,
                'rep3_master_count' => 50,
            ],
            [
                'menu_id' => 1,
                'step_number' => 2,
                'name' => "インクライン・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 20,
                'rep3_master_count' => 40,
            ],
            [
                'menu_id' => 1,
                'step_number' => 3,
                'name' => "ニーリング・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 12,
                'rep3_start_count' => 15,
                'rep3_master_count' => 30,
            ],
            [
                'menu_id' => 1,
                'step_number' => 4,
                'name' => "ハーフ・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 8,
                'rep2_start_count' => 10,
                'rep3_start_count' => 25,
                'rep3_master_count' => 0,
            ],
            [
                'menu_id' => 1,
                'step_number' => 5,
                'name' => "フル・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_id' => 1,
                'step_number' => 6,
                'name' => "クローズ・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_id' => 1,
                'step_number' => 7,
                'name' => "アンイーブン・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_id' => 1,
                'step_number' => 8,
                'name' => "ハーフ・ワンアーム・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 10,
                'rep3_master_count' => 20,
            ],
            [
                'menu_id' => 1,
                'step_number' => 9,
                'name' => "レバー・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_id' => 1,
                'step_number' => 10,
                'name' => "ワンアーム・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 50,
                'rep3_master_count' => 0,
            ],
            [
                'menu_id' => 2,
                'step_number' => 1,
                'name' => "ショルダースタンド・スクワット",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 25,
                'rep3_master_count' => 50,
            ],
            [
                'menu_id' => 2,
                'step_number' => 2,
                'name' => "ジャックナイフ・スクワット",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 20,
                'rep3_master_count' => 40,
            ],
            [
                'menu_id' => 2,
                'step_number' => 3,
                'name' => "サポーティッド・スクワット",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 12,
                'rep3_start_count' => 15,
                'rep3_master_count' => 30,
            ],
        ]);
    }
}
