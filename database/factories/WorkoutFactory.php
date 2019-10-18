<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\Master\MenuMaster;
use App\Model\Master\StepMaster;
use App\Model\UserData\WorkoutSet;
use App\Model\UserData\User;
use App\Model\UserData\Workout;
use Faker\Generator as Faker;

$factory->define(Workout::class, function (Faker $faker) {
    $menuId = mt_rand(1,MenuMaster::MASTER_COUNT);
    $stepIdMin = ($menuId-1)*StepMaster::STEP_NUMBER_MAX+1;
    $stepIdMax = $menuId*StepMaster::STEP_NUMBER_MAX;
    $stepId = mt_rand($stepIdMin, $stepIdMax);
    return [
//        'id',
        'user_id' => factory(App\Model\UserData\User::class)->create()->id,
        'menu_master_id' => $menuId,
        'step_master_id'=> $stepId,
        'count' => mt_rand(1,50),
        'difficulty_type' => mt_rand(1, count(config('pritra.DIFFICULTY_LIST'))),
    ];
});

$factory->state(Workout::class,'withParent', function($faker){
    return [
        'parent_id' => factory(Workout::class)->create()->id,
    ];
});