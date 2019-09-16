<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\Master\MenuMaster;
use App\Model\Master\StepMaster;
use App\Model\UserData\User;
use App\Model\UserData\WorkoutSet;
use App\Model\UserData\Workout;
use Faker\Generator as Faker;

$factory->define(Workout::class, function (Faker $faker) {
    $userId = factory(App\Model\UserData\User::class)->create()->id;
    $menuId = factory(MenuMaster::class)->create()->id;
    return [
//        'id',
        'user_id' => $userId,
        'menu_master_id' => $menuId,
        'step_master_id'=> factory(StepMaster::class)->create(['menu_master_id' => $menuId])->id,
        'count' => mt_rand(1,50),
        'difficulty_type' => mt_rand(1, count(config('pritra.DIFFICULTY_LIST'))),
    ];
});

$factory->state(Workout::class,'withParent', [
        'parent_id' => factory(Workout::class)->create()->id,
]);

$factory->afterCreating(Workout::class, function ($workout, $faker) {
    if($workout->hasParent()){
        $workoutIds = "$this->parent_id,$this->id";
    }
    else {
        $workoutIds = "$this->id";
    }
    $workout->workoutSet()->save(factory(WorkoutSet::class)->create([
        'workout_ids'=> $workoutIds,
        'menu_master_id' => $this->menu_master_id,
    ]));

    $workout->workoutSet->setWorkoutSetInfo();
    $workout->workoutSet->save();
});