<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Master\StepMaster;
use App\Model\Master\MenuMaster;
use Faker\Generator as Faker;

$factory->define(StepMaster::class, function (Faker $faker) {
    return [
//        'id',
        'menu_master_id' => factory(MenuMaster::class)->create()->id,
        'step_number' => mt_rand(1, StepMaster::STEP_NUMBER_MAX),
        'name' => $faker->streetName,
        'description' => $faker->name,
        'level1_rep_count' => mt_rand(1,10),
        'level1_set_count' => mt_rand(1,2),
        'level2_rep_count' => mt_rand(11,20),
        'level2_set_count' => mt_rand(3,4),
        'level3_rep_count' => mt_rand(21,100),
        'level3_set_count' => mt_rand(5,6),
    ];
});
