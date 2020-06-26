<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Model\Master\MenuMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\UserData\WorkoutSet;
use Illuminate\Database\Eloquent\Collection;

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
            $planedWorkoutSet_l = $this->__inputSetPlan($request);
        }
        catch(BadRequestException $e) {
            return abort($e->getCode(), $e->getMessage());
        }

        foreach ($planedWorkoutSet_l as $planedWorkoutSet){
            $planedWorkoutSet->save();
        }
        return response('plan create',Controller::HTTP_STATUS_CREATE);
    }

    public function showPlan(Request $request)
    {
        $planedWorkoutSet_l = $this->user->getPlan_l();
        if ($planedWorkoutSet_l->count() === 0){
            return abort(Controller::HTTP_STATUS_NO_CONTENT, "there is no plan");
        }
        else {
            return $this->__getReturnShowPlan($planedWorkoutSet_l);
        }
    }

    private function __getReturnShowPlan(Collection $planedWorkoutSet_l)
    {
        $return_l = [];
        foreach( $planedWorkoutSet_l as $planedWorkoutSet){
            $return_l[$planedWorkoutSet->menu_master_id] = [];
            $return_l[$planedWorkoutSet->menu_master_id]['menuName'] = $planedWorkoutSet->menu->name;
            $return_l[$planedWorkoutSet->menu_master_id]['stepName'] = $planedWorkoutSet->step->name;
            $return_l[$planedWorkoutSet->menu_master_id]['stepImageUrl'] = $planedWorkoutSet->step->getImageUrl();
            $return_l[$planedWorkoutSet->menu_master_id]['planedRepCount'] = $planedWorkoutSet->planed_min_rep_count;
            $return_l[$planedWorkoutSet->menu_master_id]['planedSetCount'] = $planedWorkoutSet->planed_set_count;
        }
        return $return_l;
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
        $minRepCount = PHP_INT_MAX;
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

    public function showHistory(Request $request)
    {
        return $this->responseNotImplemented();
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
        $planInfo = $request->input();
        $workoutSet_l = [];
        if (empty($planInfo)) throw new BadRequestException("Bad Request", Controller::HTTP_STATUS_BAD_REQUEST);
        foreach ($planInfo as $menuId => $workoutSetInfo){
            if ($menuId <=0 or $menuId >= MenuMaster::MASTER_COUNT)throw new BadRequestException("Bad Request", Controller::HTTP_STATUS_BAD_REQUEST);
            $workoutSet = $this->user->createPlanedWorkoutSet(
                $menuId,
                $workoutSetInfo['stepId'],
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
