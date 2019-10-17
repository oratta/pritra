<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\UserData\WorkoutSet;
use Faker\Generator as Faker;

$factory->define(WorkoutSet::class, function (Faker $faker) {
    return [
//        'id',
        'user_id' => factory(App\Model\UserData\User::class)->create()->id,
        'menu_master_id' => factory(\App\Model\Master\MenuMaster::class)->create()->id,
//        'workout_ids',
        'start_time' => now(),
        'end_time' => now(),
//        'min_step_master_id',
//        'min_rep_count',
//        'set_count',
//        'level',
//        'step_level',
    ];
});

$factory->afterCreatingState(Workout::class, 'withWorkout', function(){
   //TODO
});
