<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Master\MenuMaster;
use Faker\Generator as Faker;

$factory->define(MenuMaster::class, function (Faker $faker) {
    return [
//        'id',
        'name' => $faker->name,
        'description' => $faker->streetName,
    ];
});
