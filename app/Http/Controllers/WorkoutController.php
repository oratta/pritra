<?php

namespace App\Http\Controllers;

use App\Model\UserData\Workout;
use App\Model\Entity\WorkoutSet;
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

        $menuStepList = $stepList;
        $menuList = $menuNameList->toArray();
        $difficultyList = config('pritra.DIFFICULTY_LIST');


        return view('workout.create',
            compact('menuList','menuStepList', 'difficultyList', 'lastWorkoutSetList',
                'selectMenuId', 'selectStepId', 'selectCount', 'selectDifficulty'));
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
        $workout->menu_master_id = $request->input('menu_master_id');
        $workout->step_master_id = $request->input('step_master_id');
        $workout->count = $request->input('count');
        $workout->difficulty_type = $request->input('difficulty_type');

        $workout->save();

        //FIXME move to view component
        $diffList = config('pritra.DIFFICULTY_LIST');
        $successMessage ="
{$workout->menu->name}
step{$workout->step->step_number}:{$workout->step->name}
{$workout->count} reps : {$diffList[$workout->difficulty_type]}
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
