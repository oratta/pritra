<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Model\Master\MenuMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Model\UserData\WorkoutSet;

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
            $planedWorkoutSet_l = $this->__inputPlanWorkoutSet($request);
        }
        catch(BadRequestException $e) {
            return abort($e->getCode(), $e->getMessage());
        }

        foreach ($planedWorkoutSet_l as $planedWorkoutSet) $planedWorkoutSet->save();
        return response('plan create',Controller::HTTP_STATUS_CREATE);
    }

    public function showPlan(Request $request)
    {
        return $this->returnNotImplemented();
    }

    public function add(Request $request)
    {
        return $this->returnNotImplemented();
    }

    public function showHistory(Request $request)
    {
        return $this->returnNotImplemented();
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

    private function __inputPlanWorkoutSet($request)
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
