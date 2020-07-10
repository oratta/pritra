<?php

namespace App\Http\Controllers;

use App\Model\UserData\Workout;
use App\Model\UserData\WorkoutSet;
use App\Model\Master\MenuMaster;
use App\Model\Master\StepMaster;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use function Psy\debug;
use Debugbar;
use Auth;

class WorkoutController extends Controller
{
    const TEMP_USER_ID = 1; //FIXME 開発中の仮ID

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workoutList = Workout::get()->where('user_id', Auth::id())->take(50);
        return view('workout.index',compact('workoutList'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($recommend = '')
    {
        if($recommend){
            list($selectMenuId, $selectStepId, $selectCount, $selectDifficulty) = explode('_', $recommend);
        }
        else {
            list($selectMenuId, $selectStepId, $selectCount, $selectDifficulty) = [0,0,20,3];
        }

        $menuNameList = MenuMaster::pluck('name','id');
        $stepNameList = StepMaster::select('menu_master_id','id','name', 'step_number')
                            ->get();

        $stepList = [];
        $stepNameList->each(function($step) use (&$stepList) {
           if(!isset($stepList[$step->menu_master_id])) $stepList[$step->menu_master_id] = array();
           $stepList[$step->menu_master_id][$step->id] = "step" . $step->step_number . ":" .$step->name;
        });

        $lastWorkoutSetList = WorkoutSet::getLastWorkoutSetList(Auth::id());
        $bestWorkoutSetList = WorkoutSet::getBestWorkoutSetList(Auth::id());
        $progressBarInfoArray = $this->getProgressBarInfoArray($lastWorkoutSetList, $bestWorkoutSetList);

        $menuStepList = $stepList;
        $menuList = $menuNameList->toArray();
        $difficultyList = config('pritra.DIFFICULTY_LIST');

        return view('workout.create',
            compact('menuList','menuStepList', 'difficultyList', 'lastWorkoutSetList', 'bestWorkoutSetList',
                'selectMenuId', 'selectStepId', 'selectCount', 'selectDifficulty', 'progressBarInfoArray'));
    }

    private function getProgressBarInfoArray(array $lastWorkoutSetList, array $bestWorkoutSetList)
    {
        $progressBarInfoArray = [];
        for ($menuId = 1; $menuId <= config('pritra.MENU_COUNT'); ++$menuId) {
            $progressBarInfo = [];
            $progressBarInfo[0] = $lastWorkoutSetList[$menuId] ?? new WorkoutSet(["menu_master_id" => $menuId]);
            $progressBarInfo[1] = $bestWorkoutSetList[$menuId] ?? new WorkoutSet(["menu_master_id" => $menuId]);
            $progressBarInfoArray[$menuId] = $progressBarInfo;
        }

        return $progressBarInfoArray;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $workout = new Workout;
        $workout->user_id = Auth::id();
        $workout->menu_master_id = (int)$request->input('menu_master_id');
        $workout->step_master_id = (int)$request->input('step_master_id');
        $workout->count = (int)$request->input('count');
        $workout->difficulty_type = (int)$request->input('difficulty_type');
        $workout->setParentId();
        $workout->setWorkoutSet();

        $workout->saveWorkoutSet(); //1st transaction
        $workout->save(); //2nd transaction
        $workout->saveWorkoutIdToWorkoutSet(); //3rd transaction

        //FIXME move to view component
        $diffList = config('pritra.DIFFICULTY_LIST');
        $successMessage ="
{$workout->menu->name}
step{$workout->step->step_number}:{$workout->step->name}
{$workout->count} repCount : {$diffList[$workout->difficulty_type]}
 !!";
        $paramString = [$workout->menu_master_id, $workout->step_master_id, $workout->count, $workout->difficulty_type];

        return redirect('workout/create/' . implode('_',$paramString))->with('message', $successMessage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\UserData\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function show(Workout $workout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\UserData\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function edit(Workout $workout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\UserData\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workout $workout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\UserData\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workout $workout)
    {
        //
    }
}
