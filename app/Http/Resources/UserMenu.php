<?php

namespace App\Http\Resources;

use App\Http\Resources\Step as StepResource;
use App\Model\Master\MenuMaster;
use App\Model\Master\StepMaster as Step;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMenu extends JsonResource
{
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $menuInfo_l = [];
        $user = $this->resource;
        $menu_l = MenuMaster::get()->keyBy('id');
        $recommendedWorkoutSet_l = $user->getRecommendedWorkoutSets();
        $bestWorkoutSet_l = $user->getBestWorkoutSets();
        $recentWorkoutSet_l = $user->getRecentWorkoutSet_l(3);
        foreach ($menu_l as $menuId => $menu){
            $menuInfo_l[$menuId]['name'] = $menu->name;
            $menuInfo_l[$menuId]['id'] = $menu->id;
            $menuInfo_l[$menuId]['recommend'] = [];
            $menuInfo_l[$menuId]['recommend']['step'] = [];
            $menuInfo_l[$menuId]['recommend']['step']['id'] = $recommendedWorkoutSet_l[$menuId]->step->id;
            $menuInfo_l[$menuId]['recommend']['step']['name'] = $recommendedWorkoutSet_l[$menuId]->step->getViewName();
            $menuInfo_l[$menuId]['recommend']['reps'] = $recommendedWorkoutSet_l[$menuId]->min_rep_count;
            $menuInfo_l[$menuId]['recommend']['set'] = $recommendedWorkoutSet_l[$menuId]->set_count;
            $menuInfo_l[$menuId]['step_l'] = StepResource::collection($menu->steps->keyBy('id'));
            $historyInfo = [];
            $historyInfo['best'] = $bestWorkoutSet_l[$menuId];
            $historyInfo['recent'] = $recentWorkoutSet_l[$menuId];
            $menuInfo_l[$menuId]['historyInfo'] = $historyInfo;
        }
        return $menuInfo_l;
    }
}
