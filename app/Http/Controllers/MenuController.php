<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Master\MenuMaster;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = MenuMaster::all();
        return view('menus.index', compact('menus'));
    }

    /***
     *  menu_s:[
     *      1:{
     *          name: Push Up
     *          recommend:{
     *              stepNumber: 1
     *              reps: 20
     *              set: 10
     *          },
     *          stepName_s:[
     *              wall stand push up, ....,..., full push up
     *          ],
     *          stepInfo:{
     *              levelInfo_l:[
     *                  {
     *                      name: half push up
     *                      lv: [{rep:2, set:1},{},,,]
     *                  }, * number of steps
     *              ],
     *              best: {
     *                  name: Full Push Up
     *                  lv: 2
     *                  rep: 20
     *                  set: 2
     *                  date: 2012/02/23
     *              },
     *              recent: [
     *                  { same as best }, *3
     *              ]
     *          }
     *      }
     *      2:{...}...
     * ]
     */
    public function indexUserMenu(Request $request)
    {
        $menuInfo_l = [];
        $menu_l = MenuMaster::get()->keyBy('id');
        $recommendedWorkoutSet_l = $this->user->getRecommendedWorkoutSets();
        $bestWorkoutSet_l = $this->user->getBestWorkoutSet_l();
        $recentWorkoutSet_l = $this->user->getRecentWorkoutSet_l(3);
        $levelInfo_l = Step::getLevelInfo_l();
        foreach ($menu_l as $menuId => $menu){
            $menuInfo_l[$menuId]['name'] = $menu->name;
            $menuInfo_l[$menuId]['recommend'] = [];
            $menuInfo_l[$menuId]['recommend']['stepNumber'] = $recommendedWorkoutSet_l[$menuId]['stepNumber'];
            $menuInfo_l[$menuId]['recommend']['reps'] = $recommendedWorkoutSet_l[$menuId]['reps'];
            $menuInfo_l[$menuId]['recommend']['set'] = $recommendedWorkoutSet_l[$menuId]['set'];
            $menuInfo_l[$menuId]['stepName_l'] = $menu->steps->pluck('name');
            $stepInfo = [];
            $stepInfo['best'] = $bestWorkoutSet_l[$menuId];
            $stepInfo['recent'] = $recentWorkoutSet_l[$menuId];
            $stepInfo['levelInfo_l'] = $levelInfo_l[$menuId];
            $menuInfo_l[$menuId]['stepInfo'] = $stepInfo;
        }

        return $menuInfo_l;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = MenuMaster::find($id);
        return view('menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
