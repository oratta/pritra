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

    private function __requestAndAssertHTTPStatus($data, $expectedCode)
    {
        $response = $this->actingAs($this->user)
            ->json('post', route('workout_set.set_plan'), $data);
        $response->assertStatus($expectedCode);
    }

    /**
     * @test
     */
    public function should_プランを設定したらDBに保存する()
    {
        /*
         * ログインしていないと使えない
         */
        $response = $this->json('post', route('workout_set.set_plan'));
        $response->assertStatus(Controller::HTTP_UNAUTHORIZED);

        /*
         * データがおかしいときに400HTTP_BAD_REQUESTを返す
         */
        //範囲外のメニューID
        $this->__requestAndAssertHTTPStatus([0=> ['stepNumber'=>1,'rep'=>20,'set'=>2]], Controller::HTTP_BAD_REQUEST);
        $this->__requestAndAssertHTTPStatus([10=> ['stepNumber'=>1,'rep'=>20,'set'=>2]], Controller::HTTP_BAD_REQUEST);

        //範囲外のstepNumber
        $this->__requestAndAssertHTTPStatus([1=> ['stepNumber'=>0,'rep'=>20,'set'=>2]], Controller::HTTP_BAD_REQUEST);
        $this->__requestAndAssertHTTPStatus([1=> ['stepNumber'=>11,'rep'=>20,'set'=>2]], Controller::HTTP_BAD_REQUEST);

        //データが空
        $this->__requestAndAssertHTTPStatus([], Controller::HTTP_BAD_REQUEST);


        /*
         * 201(HTTP_STATUS_CREATEを返す
         */
        $data = [
            1 => [
                'stepNumber'    => 1,
                'rep'           => 20,
                'set'           => 2
            ],
            5 => [
                'stepNumber'    => 10,
                'rep'           => 150,
                'set'           => 3
            ],
        ];
        $response = $this->actingAs($this->user)
            ->json('post', route('workout_set.set_plan'));
        $response->assertStatus(Controller::HTTP_STATUS_CREATE);

        /*
         * 設定したプランがisPlanのWorkoutSetとしてDBに保存されている
         */
        $plan = WorkoutSet::findAll(['user_id'=>$this->user->id, 'is_plan'=>1]);
        $plan_l = $this->user->getPlan();
        $this->assertEquals($data->size(), $plan->size());
        foreach([1,5] as $i){
            $this->assertEquals($i, $plan_l[$i]->menuId);
            $this->assertEquals($data[$i]['stepNumber'], $plan[$i]->stepNumnber);
            $this->assertEquals($data[$i]['rep'], $plan[$i]->rep);
            $this->assertEquals($data[$i]['set'], $plan[$i]->set);
        }

    }

    /**
     * @test
     */
    public function should_実行中のプランを表示する()
    {
        $this->notImplemented();
        /**
         * ログインしていないと使えない
         */

        /**
         * 不正なアクセスで400
         */
        //プランがない(実行済み)

        /**
         * 200を返す
         */

        /**
         * dbのプランの情報をjsonで返す
         */
    }

    /**
     * @test
     */
    public function should_実行したワークアウトをDBに保存する()
    {
        $this->notImplemented();
        /**
         * ログインしていないと使えない
         */
        /**
         * 不正なアクセスで400
         */
        /**
         * 201を返す
         */
        /**
         * plan中のworkoutSetが実行後のデータになっている
         */
        /**
         * workoutが保存されている
         */
    }

    /*
     * @test
     */
    public function should_指定されたWorkoutSetの情報を返す()
    {
        $this->notImplemented();
        /**
         * ログインしていないと使えない
         */
        /**
         * 不正なアクセスで400
         */
        //指定されたWorkoutSetがない
        //指定されたWorkoutSetが自分のではない

        /**
         * 200を返す
         */

        /**
         * 指定されたWorkoutSetのDataをJsonとして返している
         */

        /**
         * workoutが保存されている
         */
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
