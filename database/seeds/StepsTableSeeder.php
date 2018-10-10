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
                'menu_master_id' => 1,
                'step_number' => 1,
                'name' => "ウォール・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 25,
                'rep3_master_count' => 50,
            ],
            [
                'menu_master_id' => 1,
                'step_number' => 2,
                'name' => "インクライン・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 20,
                'rep3_master_count' => 40,
            ],
            [
                'menu_master_id' => 1,
                'step_number' => 3,
                'name' => "ニーリング・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 12,
                'rep3_start_count' => 15,
                'rep3_master_count' => 30,
            ],
            [
                'menu_master_id' => 1,
                'step_number' => 4,
                'name' => "ハーフ・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 8,
                'rep2_start_count' => 10,
                'rep3_start_count' => 25,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 1,
                'step_number' => 5,
                'name' => "フル・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 1,
                'step_number' => 6,
                'name' => "クローズ・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 1,
                'step_number' => 7,
                'name' => "アンイーブン・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 1,
                'step_number' => 8,
                'name' => "ハーフ・ワンアーム・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 10,
                'rep3_master_count' => 20,
            ],
            [
                'menu_master_id' => 1,
                'step_number' => 9,
                'name' => "レバー・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 1,
                'step_number' => 10,
                'name' => "ワンアーム・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 50,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 2,
                'step_number' => 1,
                'name' => "ショルダースタンド・スクワット",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 25,
                'rep3_master_count' => 50,
            ],
            [
                'menu_master_id' => 2,
                'step_number' => 2,
                'name' => "ジャックナイフ・スクワット",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 20,
                'rep3_master_count' => 40,
            ],
            [
                'menu_master_id' => 2,
                'step_number' => 3,
                'name' => "サポーティッド・スクワット",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 12,
                'rep3_start_count' => 15,
                'rep3_master_count' => 30,
            ],
            [
                'menu_master_id' => 2,
                'step_number' => 4,
                'name' => "ハーフ・スクワット",
                'description' => '',
                'rep1_start_count' => 8,
                'rep2_start_count' => 15,
                'rep3_start_count' => 50,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 2,
                'step_number' => 5,
                'name' => "フル・スクワット",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 30,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 2,
                'step_number' => 6,
                'name' => "クローズ・スクワット",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 2,
                'step_number' => 7,
                'name' => "アンイーブン・スクワット",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 2,
                'step_number' => 8,
                'name' => "ハーフ・ワンレッグ・スクワット",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 2,
                'step_number' => 9,
                'name' => "アシステッド・ワンレッグ・スクワット",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 2,
                'step_number' => 10,
                'name' => "ワンレッグ・スクワット",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 50,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 3,
                'step_number' => 1,
                'name' => "ヴァーチカル・プル",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 20,
                'rep3_master_count' => 40,
            ],
            [
                'menu_master_id' => 3,
                'step_number' => 2,
                'name' => "ホリゾンタル・プル",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 25,
                'rep3_master_count' => 30,
            ],
            [
                'menu_master_id' => 3,
                'step_number' => 2,
                'name' => "ヴァーチカル・プル",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 25,
                'rep3_master_count' => 30,
            ],
            [
                'menu_master_id' => 3,
                'step_number' => 3,
                'name' => "ジャックナイフ・プル",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 12,
                'rep3_start_count' => 15,
                'rep3_master_count' => 20,
            ],
            [
                'menu_master_id' => 3,
                'step_number' => 4,
                'name' => "ハーフ・プルアップ",
                'description' => '',
                'rep1_start_count' => 8,
                'rep2_start_count' => 9,
                'rep3_start_count' => 11,
                'rep3_master_count' => 15,
            ],
            [
                'menu_master_id' => 3,
                'step_number' => 5,
                'name' => "フル・プルアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 7,
                'rep3_start_count' => 8,
                'rep3_master_count' => 10,
            ],
            [
                'menu_master_id' => 3,
                'step_number' => 6,
                'name' => "クローズ・プルアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 9,
                'rep3_start_count' => 11,
                'rep3_master_count' => 15,
            ],
            [
                'menu_master_id' => 3,
                'step_number' => 7,
                'name' => "アンイーブン・プルアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 6,
                'rep3_start_count' => 9,
                'rep3_master_count' => 0,
            ],

            [
                'menu_master_id' => 3,
                'step_number' => 8,
                'name' => "ハーフ・ワンアーム・プルアップ",
                'description' => '',
                'rep1_start_count' => 4,
                'rep2_start_count' => 5,
                'rep3_start_count' => 8,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 3,
                'step_number' => 9,
                'name' => "アシステッド・ワンアーム・プルアップ",
                'description' => '',
                'rep1_start_count' => 3,
                'rep2_start_count' => 4,
                'rep3_start_count' => 7,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 3,
                'step_number' => 10,
                'name' => "ワンアーム・プルアップ",
                'description' => '',
                'rep1_start_count' => 1,
                'rep2_start_count' => 2,
                'rep3_start_count' => 6,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 4,
                'step_number' => 1,
                'name' => "ニー・タック",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 25,
                'rep3_master_count' => 40,
            ],
            [
                'menu_master_id' => 4,
                'step_number' => 2,
                'name' => "フラット・ニー・レイズ",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 20,
                'rep3_master_count' => 35,
            ],
            [
                'menu_master_id' => 4,
                'step_number' => 3,
                'name' => "フラット・ベント・レッグレイズ",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 12,
                'rep3_start_count' => 15,
                'rep3_master_count' => 30,
            ],
            [
                'menu_master_id' => 4,
                'step_number' => 4,
                'name' => "フラット・フロッグ・レイズ",
                'description' => '',
                'rep1_start_count' => 8,
                'rep2_start_count' => 10,
                'rep3_start_count' => 25,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 4,
                'step_number' => 5,
                'name' => "フラット・ストレート・レッグレイズ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 4,
                'step_number' => 6,
                'name' => "ハンギング・ニー・レイズ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 15,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 4,
                'step_number' => 7,
                'name' => "ハンギング・ベント・レッグレイズ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 15,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 4,
                'step_number' => 8,
                'name' => "ハンギング・フロッグ・レイズ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 15,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 4,
                'step_number' => 9,
                'name' => "パーシャル・ストレート・レッグレイズ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 15,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 4,
                'step_number' => 10,
                'name' => "ハンギング・ストレート・レッグレイズ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 30,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 5,
                'step_number' => 1,
                'name' => "ショート・ブリッジ",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 25,
                'rep3_master_count' => 50,
            ],
            [
                'menu_master_id' => 5,
                'step_number' => 2,
                'name' => "ストレート・ブリッジ",
                'description' => '',
                'rep1_start_count' => 10,
                'rep2_start_count' => 15,
                'rep3_start_count' => 20,
                'rep3_master_count' => 40,
            ],
            [
                'menu_master_id' => 5,
                'step_number' => 3,
                'name' => "アングルド・ブリッジ",
                'description' => '',
                'rep1_start_count' => 8,
                'rep2_start_count' => 10,
                'rep3_start_count' => 15,
                'rep3_master_count' => 30,
            ],
            [
                'menu_master_id' => 5,
                'step_number' => 4,
                'name' => "ヘッド・ブリッジ",
                'description' => '',
                'rep1_start_count' => 8,
                'rep2_start_count' => 10,
                'rep3_start_count' => 25,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 5,
                'step_number' => 5,
                'name' => "ハーフ・ブリッジ",
                'description' => '',
                'rep1_start_count' => 8,
                'rep2_start_count' => 10,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 5,
                'step_number' => 6,
                'name' => "フル・ブリッジ",
                'description' => '',
                'rep1_start_count' => 6,
                'rep2_start_count' => 8,
                'rep3_start_count' => 15,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 5,
                'step_number' => 7,
                'name' => "ウォールウォーキング・ブリッジ(下向き)",
                'description' => '',
                'rep1_start_count' => 3,
                'rep2_start_count' => 4,
                'rep3_start_count' => 10,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 5,
                'step_number' => 8,
                'name' => "ウォールウォーキング・ブリッジ(上向き)",
                'description' => '',
                'rep1_start_count' => 2,
                'rep2_start_count' => 3,
                'rep3_start_count' => 8,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 5,
                'step_number' => 9,
                'name' => "クロージング・ブリッジ",
                'description' => '',
                'rep1_start_count' => 1,
                'rep2_start_count' => 2,
                'rep3_start_count' => 6,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 5,
                'step_number' => 10,
                'name' => "スタンド・トゥ・スタンド・ブリッジ",
                'description' => '',
                'rep1_start_count' => 1,
                'rep2_start_count' => 2,
                'rep3_start_count' => 30,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 6,
                'step_number' => 1,
                'name' => "ウォール・ヘッドスタンド",
                'description' => '',
                'rep1_start_count' => 10030,
                'rep2_start_count' => 10120,
                'rep3_start_count' => 0,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 6,
                'step_number' => 2,
                'name' => "クロウ・スタンド",
                'description' => '',
                'rep1_start_count' => 10010,
                'rep2_start_count' => 10060,
                'rep3_start_count' => 0,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 6,
                'step_number' => 3,
                'name' => "ウォール・ハンドスタンド",
                'description' => '',
                'rep1_start_count' => 10030,
                'rep2_start_count' => 10120,
                'rep3_start_count' => 0,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 6,
                'step_number' => 4,
                'name' => "ハーフ・スタンド・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 20,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 6,
                'step_number' => 5,
                'name' => "ハンドスタンド・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 15,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 6,
                'step_number' => 6,
                'name' => "クローズ・ハンドスタンド・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 7,
                'rep3_start_count' => 12,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 6,
                'step_number' => 7,
                'name' => "アンイーブン・ハンドスタンド・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 5,
                'rep2_start_count' => 8,
                'rep3_start_count' => 10,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 6,
                'step_number' => 8,
                'name' => "ハーフ・ワンアーム・ハンドスタンド・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 4,
                'rep2_start_count' => 5,
                'rep3_start_count' => 8,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 6,
                'step_number' => 9,
                'name' => "レバー・ハンドスタンド・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 2,
                'rep2_start_count' => 4,
                'rep3_start_count' => 6,
                'rep3_master_count' => 0,
            ],
            [
                'menu_master_id' => 6,
                'step_number' => 10,
                'name' => "ワンアーム・ハンドスタンド・プッシュアップ",
                'description' => '',
                'rep1_start_count' => 1,
                'rep2_start_count' => 2,
                'rep3_start_count' => 5,
                'rep3_master_count' => 0,
            ],
        ]);
    }
}
