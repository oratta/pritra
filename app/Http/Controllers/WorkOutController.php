<?php

namespace App\Http\Controllers;

use App\WorkOut;
use App\Model\Master\MenuMaster;
use App\Model\Master\StepMaster;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use function Psy\debug;
use Debugbar;
use Auth;

class WorkOutController extends Controller
{
    const TEMP_USER_ID = 1; //FIXME 開発中の仮ID

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workOutList = WorkOut::get()->where('user_id', Auth::id())->take(50);
        return view('workOut.index',compact('workOutList'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuNameList = MenuMaster::pluck('name','id');
        $stepNameList = StepMaster::select('menu_master_id','id','name', 'step_number')
                            ->get();

        $stepList = [];
        $stepNameList->each(function($step) use (&$stepList) {
           if(!isset($stepList[$step->menu_master_id])) $stepList[$step->menu_master_id] = array();
           $stepList[$step->menu_master_id][$step->step_number] = $step->name;
        });

        $lastLogList = WorkOut::getLastLogList(Auth::id());

        $menuStepList = $stepList;
        $menuList = $menuNameList->toArray();
        $difficultyList = config('pritra.DIFFICULTY_LIST');

        return view('workOut.create',compact('menuList','menuStepList', 'difficultyList', 'lastLogList'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $workOut = new WorkOut;
        $workOut->user_id = Auth::id();
        $workOut->menu_master_id = $request->input('menu_master_id');
        $workOut->step_master_id = $request->input('step_master_id');
        $workOut->count = $request->input('count');
        $workOut->difficulty_type = $request->input('difficulty_type');

        $workOut->save();

        return view('workOut.stored',
            array_merge([
                'difficultyList' => config('pritra.DIFFICULTY_LIST')],
                compact('workOut')));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WorkOut  $workOut
     * @return \Illuminate\Http\Response
     */
    public function show(WorkOut $workOut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkOut  $workOut
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkOut $workOut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkOut  $workOut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkOut $workOut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkOut  $workOut
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkOut $workOut)
    {
        //
    }
}
