<?php

namespace Tests\Unit\Model\UserData;

use App\Model\UserData\WorkoutSet;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\UserData\Workout;

class WorkoutTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

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
}
