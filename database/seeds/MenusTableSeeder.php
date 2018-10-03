<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            [
                'name'  => 'プッシュアップ',
                'description' => '',
            ],
            [
                'name'  => 'スクワット',
                'description' => '',
            ],
            [
                'name'  => 'プルアップ',
                'description' => '',
            ],
            [
                'name'  => 'レッグレイズ',
                'description' => '',
            ],
            [
                'name'  => 'ブリッジ',
                'description' => '',
            ],
            [
                'name'  => 'ハンドスタンドプッシュアップ',
                'description' => '',
            ],
        ]);
    }
}