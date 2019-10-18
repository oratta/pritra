<?php

namespace Tests\Unit\Model\UserData;

use App\Model\UserData\WorkoutSet;
use Carbon\Carbon;
use Tests\SeedingDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\UserData\Workout;
use \Mockry as m;

class WorkoutTest extends TestCase
{
    use RefreshDatabase;
    use SeedingDatabase;

    public function testIsNowWorkoutSet()
    {
        $reflectionWorkout = self::setAccessable('App\Model\UserData\Workout', 'isNowWorkoutSet');

        //同時刻
        $latestWorkout = new Workout;
        $latestWorkout->created_at = Carbon::now();
        $this->assertTrue($reflectionWorkout->invoke($latestWorkout));

        //日付違い
        $latestWorkout->created_at = Carbon::now()->addDay();
        $this->assertFalse($reflectionWorkout->invoke($latestWorkout));
    }

    public function testConstruct()
    {
        $workout = new Workout;
        $this->assertEquals(-1, $workout->parent_id);
        $this->assertEquals(0, $workout->workout_set_id);
    }

    public function testSetWorkoutSet()
    {
        $parentId = 1;

        /*
         * Exception pattern
         */
        $workout = new Workout;
        try{
            $workout->setWorkoutSet();
            $this->fail();
        }catch(\Exception $e){
            $this->assertTrue(true);
        }

        /*
         * has parent pattern
         */
        $parent = factory(Workout::class)->create(
            [
                'id' => $parentId,
                'parent_id' => 0,
                ]);
        $workout = new Workout;
        $workout->parent_id = $parentId;
        $workout->setWorkoutSet();
        $this->assertEquals($parent->workout_set_id, $workout->workout_set_id);

        /*
         * has no parent pattern
         */
        $workout = factory(Workout::class)->create(['parent_id' => 0]);
        $workout->setWorkoutSet();
        $this->assertDatabaseHas('workout_sets', ['id' => $workout->workout_set_id]);
    }
}
