<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use App\Model\Master\MenuMaster;
use App\Model\Master\StepMaster;
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
        $response->assertStatus(Controller::HTTP_STATUS_UNAUTHORIZED);


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

    private function __requestAndAssertHTTPStatus($method, $routeName, $expectedCode, $data=[])
    {
        $response = $this->actingAs($this->user)
            ->json($method, route($routeName), $data);
        $response->assertStatus($expectedCode);

        return $response;
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
        $response->assertStatus(Controller::HTTP_STATUS_UNAUTHORIZED);

        /*
         * データがおかしいときに400HTTP_STATUS_BAD_REQUESTを返す
         */
        //範囲外のメニューID
        $this->__requestAndAssertHTTPStatus(
            'post','workout_set.set_plan',
            Controller::HTTP_STATUS_BAD_REQUEST,
            [0=> ['stepId'=>1,'repCount'=>20,'setCount'=>2]]);
        $this->__requestAndAssertHTTPStatus(
            'post','workout_set.set_plan',
            Controller::HTTP_STATUS_BAD_REQUEST,
            [10=> ['stepId'=>1,'repCount'=>20,'setCount'=>2]]);

        //データが空
        $this->__requestAndAssertHTTPStatus(
            'post','workout_set.set_plan',
            Controller::HTTP_STATUS_BAD_REQUEST,
            []);


        /*
         * 201(HTTP_STATUS_CREATEを返す
         */
        $data = [
            1 => [
                'stepId'    => 1,
                'repCount'           => 20,
                'setCount'           => 2
            ],
            5 => [
                'stepId'    => 10,
                'repCount'           => 150,
                'setCount'           => 3
            ],
        ];
        $response = $this->actingAs($this->user)
            ->json('post', route('workout_set.set_plan'), $data);
        $response->assertStatus(Controller::HTTP_STATUS_CREATE);

        /*
         * 設定したプランがisPlanのWorkoutSetとしてDBに保存されている
         */
        $plan_l = $this->user->getPlan_l();
        $this->assertEquals(count($data), $plan_l->count());
        foreach([1,5] as $i){
            $this->assertEquals($i, $plan_l->get($i)->menu_master_id);
            $this->assertEquals($data[$i]['stepId'], $plan_l->get($i)->min_step_master_id);
            $this->assertEquals($data[$i]['repCount'], $plan_l->get($i)->planed_min_rep_count);
            $this->assertEquals($data[$i]['setCount'], $plan_l->get($i)->planed_set_count);
        }

    }

    private function __requestAndAssertLogin($method, $routeName)
    {
        $response = $this->json($method, route($routeName));
        $response->assertStatus(Controller::HTTP_STATUS_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function should_実行中のプランを表示する()
    {
        /**
         * ログインしていないと使えない
         */
        $this->__requestAndAssertLogin('get', 'workout_set.show_plan');

        /**
         * 204を返す
         */
        //実行中のプランが存在しない
        $this->__requestAndAssertHTTPStatus(
            'get', 'workout_set.show_plan',
            Controller::HTTP_STATUS_NO_CONTENT
        );

        /**
         * 200を返す
         */
        //プランの作成
        $masterId_a = 1;
        $stepId_a   = 2;
        $masterId_b = 5;
        $stepId_b   = 42;
        $data = [
            $masterId_a => [
                'stepId'    => $stepId_a,
                'repCount'           => 20,
                'setCount'           => 2
            ],
            $masterId_b => [
                'stepId'    => $stepId_b,
                'repCount'           => 150,
                'setCount'           => 3
            ],
        ];
        $this->actingAs($this->user)->json('post', route('workout_set.set_plan'), $data);

        $response = $this->__requestAndAssertHTTPStatus(
            'get', 'workout_set.show_plan',
            Controller::HTTP_STATUS_OK
        );

        /**
         * dbのプランの情報をjsonで返す
         */
        $menu_l = MenuMaster::whereIn('id',[$masterId_a,$masterId_b])->get()->keyBy('id');
        $step_l = StepMaster::whereIn('id',[$stepId_a, $stepId_b])->get()->keyBy('id');
        $expected = [];
        foreach ([$masterId_a,$masterId_b] as $i){
            $stepId = $data[$i]['stepId'];
            $expected[$i] = [
                'menuName' => $menu_l->get($i)->name,
                'stepName' => $step_l->get($stepId)->name,
                'stepImageUrl' => $step_l->get($stepId)->getImageUrl(),
                'planedRepCount' => $data[$i]['repCount'],
                'planedSetCount' => $data[$i]['setCount'],
            ];
        }
        $response->assertJson($expected);
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
