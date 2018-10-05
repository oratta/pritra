<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'  => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('adminadmin'),
                'type' => 1,
            ],
            [
                'name'  => 'hoge',
                'email' => 'hoge@hoge.com',
                'password' => bcrypt('hogehoge'),
                'type' => 0,
            ],
            [
                'name'  => 'fuga',
                'email' => 'fuga@fuga.com',
                'password' => bcrypt('fugafuga'),
                'type' => 0,
            ],
        ]);
    }
}
