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
        DB::table('menu_masters')->insert([
            [
                'id'    => 1,
                'name'  => 'プッシュアップ',
                'description' => '',
            ],
            [
                'id'    => 2,
                'name'  => 'スクワット',
                'description' => '',
            ],
            [
                'id'    => 3,
                'name'  => 'プルアップ',
                'description' => '',
            ],
            [
                'id'    => 4,
                'name'  => 'レッグレイズ',
                'description' => '',
            ],
            [
                'id'    => 5,
                'name'  => 'ブリッジ',
                'description' => '',
            ],
            [
                'id'    => 6,
                'name'  => 'ハンドスタンドプッシュアップ',
                'description' => '',
            ],
        ]);
    }
}
