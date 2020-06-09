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

    /**
     * @test
     */
    public function should_ユーザのリコメンドメニューとともにメニューの一覧を返す()
    {
        /*
         * fail if not login
         */
        $this->__requestAndAssertLogin("get", "show_user_menu");

        //planの作成
        $idInfo = [
            1 => 5,
            5 => 42
        ];
        $postData = $this->__createPlan($idInfo);

        /**
         * 異常系 : プランがある場合はエラーを返す
         */
        $response = $this->__requestAndAssertHTTPStatus(
            'get', 'show_user_menu',
            Controller::HTTP_STATUS_BAD_REQUEST
        );

        $this->__addWorkoutSet();

        /**
         * 正常系 : 200を返す
         */
        $response = $this->__requestAndAssertHTTPStatus(
            'get', 'show_user_menu',
            Controller::HTTP_STATUS_OK
        );

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
        //masterId => stepId
        $idInfo = [
            1 => 5,
            5 => 42
        ];
        $postData = $this->__createPlan($idInfo);

        $response = $this->__requestAndAssertHTTPStatus(
            'get', 'workout_set.show_plan',
            Controller::HTTP_STATUS_OK
        );

        /**
         * dbのプランの情報をjsonで返す
         */
        $menu_l = MenuMaster::whereIn('id',array_keys($idInfo))->get()->keyBy('id');
        $step_l = StepMaster::whereIn('id',$idInfo)->get()->keyBy('id');
        $expected = [];
        foreach ($idInfo as $masterId => $stepId){
            $expected[$masterId] = [
                'menuName' => $menu_l->get($masterId)->name,
                'stepName' => $step_l->get($stepId)->name,
                'stepImageUrl' => $step_l->get($stepId)->getImageUrl(),
                'planedRepCount' => $postData[$masterId]['repCount'],
                'planedSetCount' => $postData[$masterId]['setCount'],
            ];
        }
        $response->assertJson($expected);
    }

    private function __createPlan(array $idInfo)
    {
        $postData = [];
        foreach($idInfo as $masterId => $stepId){
            $postData[$masterId] = [
                'stepId'    => $stepId,
                'repCount'           => 20*$stepId,
                'setCount'           => 2*$masterId
            ];
        }
        $this->actingAs($this->user)->json('post', route('workout_set.set_plan'), $postData);

        return $postData;
    }

    private function __addWorkoutSet()
    {
        $planedWorkoutSet_l = WorkoutSet::where('user_id', $this->user->id)->get()->keyBy('id');
        $workoutSetId_l = $planedWorkoutSet_l->pluck('id');
        $workoutExecuteData = [];
        foreach ($workoutSetId_l as $workoutSetId){
            $workoutExecuteData[$workoutSetId] = [];
            $setCount = mt_rand(1,5);
            for($i=0;$i<$setCount;$i++){
                $workoutExecuteData[$workoutSetId][] = [
                    'repCount' => mt_rand(0,20),
                    'difficultyType' => mt_rand(1, count(config('pritra.DIFFICULTY_LIST'))),
                ];
            }
        }

        $responseAdd = $this->__requestAndAssertHttpStatus(
            'post', 'workout_set.add',
            Controller::HTTP_STATUS_CREATE,
            $workoutExecuteData
        );

        return $workoutExecuteData;
    }


    /**
     * @test
     */
    public function should_実行したワークアウトをDBに保存する_workout_set_add()
    {
        /**
         * ログインしていないと使えない
         */
        $this->__requestAndAssertLogin('post', 'workout_set.add');

        /**
         * 400 指定したworkout_setが存在しない
         */
        $this->__requestAndAssertHTTPStatus(
            'post', 'workout_set.add',
            Controller::HTTP_STATUS_BAD_REQUEST,
            [100=>[[3,1],[5,2]]]
        );

        //プランの作成
        //masterId => stepId
        $idInfo = [
            1 => 5,
            5 => 42
        ];
        $postData = $this->__createPlan($idInfo);

        $planedWorkoutSet_l = WorkoutSet::where('user_id', $this->user->id)->get()->keyBy('id');
        $this->assertEquals(count($idInfo), $planedWorkoutSet_l->count());

        $workoutSetId_l = $planedWorkoutSet_l->pluck('id');
        $workoutExecuteData = [];
        foreach ($workoutSetId_l as $workoutSetId){
            $workoutExecuteData[$workoutSetId] = [];
            $setCount = mt_rand(1,5);
            for($i=0;$i<$setCount;$i++){
                $workoutExecuteData[$workoutSetId][] = [
                    'repCount' => mt_rand(0,20),
                    'difficultyType' => mt_rand(1, count(config('pritra.DIFFICULTY_LIST'))),
                ];
            }
        }

        /*
         * 400 WorkoutSetのIDが自分のものでない
         */
        $planedWorkoutSet_l->first()->user_id += 1;
        $planedWorkoutSet_l->first()->save();
        $responseAdd = $this->__requestAndAssertHttpStatus(
            'post', 'workout_set.add',
            Controller::HTTP_STATUS_BAD_REQUEST,
            $workoutExecuteData
        );

        /**
         * 201 plan中のworkoutSetが実行後のデータになっている
         */
        $planedWorkoutSet_l->first()->user_id -= 1;
        $planedWorkoutSet_l->first()->save();
        $responseAdd = $this->__requestAndAssertHttpStatus(
            'post', 'workout_set.add',
            Controller::HTTP_STATUS_CREATE,
            $workoutExecuteData
        );
        $excusedWorkoutSet_l = WorkoutSet::where('user_id', $this->user->id)->get()->keyBy('id');
        $this->assertEquals($planedWorkoutSet_l->count(), $excusedWorkoutSet_l->count());
        foreach ($excusedWorkoutSet_l as $id => $workoutSet){
            $workoutData =  collect($workoutExecuteData[$id]);
            $minRepCount = $workoutData->min('repCount');
            $stepCount = $workoutData->count();
            $this->assertFalse($workoutSet->isPlan());
            $this->assertEquals($minRepCount,$workoutSet->min_rep_count);
            $this->assertEquals($stepCount,$workoutSet->set_count);
        }

        /**
         * 400
         * workoutIDは存在するが、すでに実行済みである
         */
        $responseAdd = $this->__requestAndAssertHttpStatus(
            'post', 'workout_set.add',
            Controller::HTTP_STATUS_BAD_REQUEST,
            $workoutExecuteData
        );

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
