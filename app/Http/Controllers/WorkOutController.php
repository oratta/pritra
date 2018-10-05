<?php

namespace App\Http\Controllers;

use App\WorkOut;
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
        $workOutList = WorkOut::all()->take(50);
        return view('workOut.index',compact('workOutList'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuStepList = config('pritra.menuStepList');
        $menuList = config('pritra.menuList');
        $strengthList = config('pritra.strengthList');

        return view('workOut.create',compact('menuList','menuStepList', 'strengthList'));
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
        $workOut->menu_type = $request->input('menu_type');
        $workOut->step = $request->input('step');
        $workOut->count = $request->input('count');
        $workOut->difficulty_type = $request->input('difficulty_type');

        $workOut->save();

        return view('workOut.stored', compact('workOut'));
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
