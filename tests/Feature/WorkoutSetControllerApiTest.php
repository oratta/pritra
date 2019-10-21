<?php

namespace Tests\Feature;

use App\Model\UserData\WorkoutSet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkoutSetControllerApiTest extends TestCase
{
    /**
     * @test
     */
    public function should_現在のベストワークアウトセットを返す()
    {
        //データがない状態
        $response = $this->actingAs($this->user)
            ->json('GET', '/workout_sets?best');
        $response->assertStatus(200);

        foreach($response->data as $workoutSet){
            $this->assertEquals(0, $workoutSet->level);
            $this->assertEquals(0, $workoutSet->step_level);
        }

        //データを入れる
        $workout = factory(Workout::class)->create(['menu_master_id' => 1]);

        $response = $this->actingAs($this->user)
            ->json('GET', '/workout_sets?best');
        $response->assertStatus(200);

        foreach($response->data as $workoutSet){
            if($workoutSet->menu_master_id === 1){
                $this->assertEquals($workout->step_master_id, $workoutSet->min_step_master_id);
                $this->assertEquals($workout->rep_count, $workoutSet->min_rep_count);
            }
            else {
                $this->assertEquals(0, $workoutSet->level);
                $this->assertEquals(0, $workoutSet->step_level);
            }
        }
    }
}
