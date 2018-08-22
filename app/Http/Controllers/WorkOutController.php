<?php

namespace App\Http\Controllers;

use App\WorkOut;
use Illuminate\Http\Request;
use function Psy\debug;

class WorkOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workOuts = WorkOut::all()->take(50);
        return $workOuts;
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
        //
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
