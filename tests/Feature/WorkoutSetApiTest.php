<?php

namespace Tests\Feature;

use App\Model\UserData\User;
use App\Model\UserData\WorkoutSet;
use Illuminate\Support\Facades\Hash;
use Tests\SeedingDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkoutSetApiTest extends TestCase
{
    use RefreshDatabase;
    use SeedingDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザー作成
        $this->user = factory(User::class)->create(["password" => Hash::make("secret")]);
    }

    /**
     * @test
     */
    public function should_現在のベストワークアウトセットを返す()
    {
        //データがない状態
        $response = $this->actingAs($this->user)
            ->json('GET', 'api/workout_sets?best');
        $response->assertStatus(200);

        $expected = [
            1 => [
                'level' => 0,
                'step_level' => 0,
            ],
            2 => [
                'level' => 0,
                'step_level' => 0,
            ],
            3 => [
                'level' => 0,
                'step_level' => 0,
            ],
            4 => [
                'level' => 0,
                'step_level' => 0,
            ],
            5 => [
                'level' => 0,
                'step_level' => 0,
            ],
            6 => [
                'level' => 0,
                'step_level' => 0,
            ],
        ];
        $response->assertJson($expected);

        //データを入れる
        $workout = factory(\App\Model\UserData\Workout::class)->create([
            'menu_master_id' => 1,
            'parent_id' => 0,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->json('GET', 'api/workout_sets?best');
        $response->assertStatus(200);

        $expected = [
            $workout->menu_master_id => [
                'min_step_master_id' => $workout->step_master_id,
                'min_rep_count' => $workout->count,
            ],
        ];
        $response->assertJson($expected);
    }

    /**
     * @test
     */
    public function should_現在のおすすめワークアウトセットを返す()
    {
        //データがない状態
        $response = $this->actingAs($this->user)
            ->json('GET', 'api/workout_sets?recommend');
        $response->assertStatus(200);

        $expected = [
            1 => [
                'level' => 1,
                'step_level' => 101,
            ],
            2 => [
                'level' => 1,
                'step_level' => 101,
            ],
            3 => [
                'level' => 1,
                'step_level' => 101,
            ],
            4 => [
                'level' => 1,
                'step_level' => 101,
            ],
            5 => [
                'level' => 1,
                'step_level' => 101,
            ],
            6 => [
                'level' => 1,
                'step_level' => 101,
            ],
        ];
        $response->assertJson($expected);

        //データを入れる
        $workout = factory(\App\Model\UserData\Workout::class)->create([
            'menu_master_id' => 1,
            'parent_id' => 0,
            'user_id' => $this->user->id,
            //TODO level1 workout count & step id
        ]);

        $response = $this->actingAs($this->user)
            ->json('GET', 'api/workout_sets?recommend');
        $response->assertStatus(200);

        $expected = [
            $workout->menu_master_id => [
                'level' => 2,
                'step_level' => 102,
            ],
        ];
        $response->assertJson($expected);
    }
}
