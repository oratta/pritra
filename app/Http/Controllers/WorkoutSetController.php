<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Model\Master\MenuMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\UserData\WorkoutSet;
use Illuminate\Database\Eloquent\Collection;
use App\Model\UserData\WorkoutSet as WorkoutSetResource;

class WorkoutSetController extends Controller
{

    /**
     * @var \App\Model\UserData\User
     */
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /***
     * @param Request $request
     *          [masterID => [
     *              'stepNumber' => 1,
     *              'repCount' => 20,
     *              'setCount' = 2,
     *          ],...]
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function setPlan(Request $request)
    {
        try{
            $plannedWorkoutSet_l = $this->__inputSetPlan($request);
        }
        catch(BadRequestException $e) {
            return $this->responseBadRequest($e);
        }

        foreach ($plannedWorkoutSet_l as $plannedWorkoutSet){
            $plannedWorkoutSet->save();
        }
        return response('plan create',Controller::HTTP_STATUS_CREATE);
    }

    public function showPlan(Request $request)
    {
        $plannedWorkoutSet_l = $this->user->getPlan_l();
        if ($plannedWorkoutSet_l->count() === 0){
            return abort(Controller::HTTP_STATUS_NO_CONTENT, "there is no plan");
        }
        else {
            return $this->__getReturnShowPlan($plannedWorkoutSet_l);
        }
    }

    private function __getReturnShowPlan(Collection $plannedWorkoutSet_l)
    {
        $planList = [];
        foreach( $plannedWorkoutSet_l as $plannedWorkoutSet){
            $id = $plannedWorkoutSet->id;
            $planList[$id] = [];
            $planList[$id]['id'] = $id;
            $planList[$id]['menu'] = [];
            $planList[$id]['menu']['name'] = $plannedWorkoutSet->menu->name;
            $planList[$id]['menu']['id'] = $plannedWorkoutSet->menu->id;
            $planList[$id]['step']['name'] = $plannedWorkoutSet->step->name;
            $planList[$id]['step']['imageUrl'] = $plannedWorkoutSet->step->getImageUrl();
            $planList[$id]['repCount'] = $plannedWorkoutSet->planned_min_rep_count;
            $planList[$id]['setCount'] = $plannedWorkoutSet->planned_set_count;
        }
        $difficultyTypeList = [];
        $tmpDifficultyList = config('pritra.DIFFICULTY_LIST');
        foreach($tmpDifficultyList as $index => $text){
            $difficulty = [];
            $difficulty['text'] = $text;
            $difficulty['value'] = $index;
            $difficultyList[] = $difficulty;
        }

        return [
            "planList" => $planList,
            "difficultyList" => $difficultyList
        ];
    }

    /***
     * @param Request $request
     * [
     *      workoutSetId => [
     *          [
     *              'repCount' => 20,
     *              'difficultyType' => 2,
     *          ],
     *          ...
     *      ],
     *      ...
     * ]
     */
    public function add(Request $request)
    {
        $executeWorkoutInfo_l = $request->input();
        $workoutSetId_l = array_keys($executeWorkoutInfo_l);
        $workoutSet_l = WorkoutSet::whereIn('id', $workoutSetId_l)->get()->keyBy('id');
        if ($workoutSet_l->count()!==count($workoutSetId_l)){
            return abort(Controller::HTTP_STATUS_BAD_REQUEST, "bad request");
        }
        foreach ($workoutSet_l as $id => $workoutSet){
            if ($workoutSet->user_id !== $this->user->id){
                return abort(Controller::HTTP_STATUS_BAD_REQUEST, "bad request");
            }
            else if($workoutSet->is_plan !== 1){
                return abort(Controller::HTTP_STATUS_BAD_REQUEST, "this workout already done");
            }
            $workoutSet->addWorkoutBulk($executeWorkoutInfo_l[$id]);
            $workoutSet->is_plan = false;
            $workoutSet->save();
        }
        return response('workouts add and fix a workout set',Controller::HTTP_STATUS_CREATE);
    }

    /***
     * @param Request $request
     * [
     *      workoutSetId => [
     *          id
     *          menu => [name]
     *          step => [name]
     *          plannedMinRepCount,
     *          plannedSetCount,
     *          setCount,
     *          repCount,
     *          workoutList => [
     *              [
     *                  repCount
     *                  difficultyType
     *              ],
     *          ]
     *      ]
     * ]
     */
    public function showLatest(Request $request)
    {
        return WorkoutSetResource::collection($this->user->getRecentWorkoutSetList());
    }

    public function index(Request $request)
    {
        if($this->__isRequestBestWorkoutSets($request)){
            return $this->indexBest();
        }
        else if($this->__isRequestRecommendedWorkoutSets($request)){
            return $this->indexRecommend();
        }
    }

    protected function indexBest()
    {
        return $this->user->getBestWorkoutSets();
    }

    protected function indexRecommend(){
        return $this->user->getRecommendedWorkoutSets();
    }

    private function __inputSetPlan($request)
    {
        $planInfo = $request->get('planInfo');
        $workoutSet_l = [];
        if (empty($planInfo)) {
            throw new BadRequestException("Bad Request", Controller::HTTP_STATUS_BAD_REQUEST);
        }
        foreach ($planInfo as $menuId => $workoutSetInfo){
            if ($menuId <=0 or $menuId >= MenuMaster::MASTER_COUNT){
                throw new BadRequestException("Bad Request", Controller::HTTP_STATUS_BAD_REQUEST);
            }
            $workoutSet = $this->user->createplannedWorkoutSet(
                $menuId,
                $workoutSetInfo['step']['id'],
                $workoutSetInfo['repCount'],
                $workoutSetInfo['setCount']
            );
            $workoutSet_l[$menuId] = $workoutSet;
        }
        return $workoutSet_l;
    }

    private function __isRequestBestWorkoutSets(Request $request)
    {
        $inputAll = $request->input();
        return key_exists('best', $inputAll);
    }

    private function __isRequestRecommendedWorkoutSets(Request $request)
    {
        $inputAll = $request->input();
        return key_exists('recommend', $inputAll);
    }
}
