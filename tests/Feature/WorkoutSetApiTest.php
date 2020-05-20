<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Model\Master\MenuMaster;
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

    private function __setWorkoutHistoryData()
    {
        $this->notImplemented();
    }

    /**
     * @test
     */
    public function should_ユーザのリコメンドメニューとともにメニューの一覧を返す()
    {
        /*
         * fail if not login
         */
        $response = $this->json('get', route('show_user_menu'));
        $response->assertStatus(Controller::HTTP_UNAUTHORIZED);


        $this->__setWorkoutHistoryData();
        $response = $this->actingAs($this->user)->json('get', route('show_user_menu'));
        $response->assertStatus(Controller::HTTP_STATUS_OK);

        /*
         * ステップごとのレベルリストが返ってくる
         * MenuMaster::getLevelInfo_l();
         */
        $expect = [
            1 => [
                'stepInfo' => [
                    'levelInfo_l' => MenuMaster::getLevelInfo_l(),
                ]
            ]
        ];
        $response->assertJsonFragment($expect);

        /*
         * ベストの情報が返ってくる
         */
        $bestWorkout = $this->user->getBest(1);
        $expect = [
            1 => [
                'stepInfo' => [
                    'best' => $bestWorkout
                ]
            ]
        ];
        $response->assertJsonFragment($expect);

        /*
         * 最近のログが3つ返ってくる
         */
        $expect = [
            1 => [
                'stepInfo' => [
                    'recent' => $this->user->getHistory(1)
                ]
            ]
        ];
        $response->assertJsonFragment($expect);

        /*
         * 一番最新+1Lvがおすすめとして返ってくる
         */
        $expect = [
            1 => [
                'recommend' => [
                    'stepNumber' => $bestWorkout->stepNumber,
                    'reps' => $bestWorkout->reps,
                    'set' => $bestWorkout->set,
                    'level' => $bestWorkout-level
                ]
            ]
        ];
        $response->assertJsonFragment($expect);
    }

    /**
     * @test
     */
    public function should_プランを設定したらDBに保存する()
    {
        $response = $this->actingAs($this->user)
            ->json('post', route('workout_set.set_plan'));
        $response->assertStatus(Controller::HTTP_STATUS_CREATE);

        $this->notImplemented();
    }

    /**
     * @test
     */
    public function should_実行中のプランを表示する()
    {
        $this->notImplemented();
    }

    /**
     * @test
     */
    public function should_実行したワークアウトをDBに保存する()
    {
        $this->notImplemented();
    }

    /*
     * @test
     */
    public function should_最後に実行したワークアウトの情報を返す()
    {
        $this->notImplemented();
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
                'step_level' => MenuMaster::getFirstStepMasterId(1)*100 + 1,
            ],
            2 => [
                'level' => 1,
                'step_level' => MenuMaster::getFirstStepMasterId(2)*100 + 1,
            ],
        ];
        $response->assertJson($expected);

        //データを入れる
        $workout = factory(\App\Model\UserData\Workout::class)->create([
            'menu_master_id' => 1,
            'parent_id' => 0,
            'user_id' => $this->user->id,
            'step_master_id' => MenuMaster::getFirstStepMasterId(1),
            'count' => 10
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
