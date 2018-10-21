<?php

namespace App\Model\Entity;

use App\Model\UserData\Workout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class WorkoutSet extends Model
{
    /**
     * @var Collection
     */
    private $workoutSetList;

    private $startTime = null;
    private $finishTime = null;
    private $workoutCount = 0;

    /**
     * @var Workout
     */
    public $nextLevelWorkout;

    public function getStartTime()
    {
        if(!$this->startTime) {
            $this->startTime = $this->workoutSetList->first()->created_at;
        }

        return $this->startTime;
    }

    public function getFinishTime()
    {
        if(!$this->finishTime) {
            $this->finishTime = $this->workoutSetList->last()->created_at;
        }
        return $this->finishTime;
    }

    /**
     * @return array
     */
    public function getWorkoutArray()
    {
        return $this->workoutSetList->all();
    }

    /**
     * @param $userId
     * @return array
     */
    static public function getLastWorkoutSetList($userId)
    {
        $lastLogList = [];

        for ($menuId = 1; $menuId <= config('pritra.MENU_COUNT'); ++$menuId) {
            $lastWorkout = static::getLastWorkoutSet($userId, $menuId);
            if($lastWorkout instanceof  WorkoutSet)$lastWorkout->setNextLevelWorkoutSet();
            $lastLogList[$menuId] = $lastWorkout;
        }

        return $lastLogList;
    }

    private function setNextLevelWorkoutSet(){
        $minStepId = $this->workoutSetList->min('step_master_id');
        $lowRepCount = 1000;
        $minStepSetCount = 0;
        $this->workoutSetList->each(function($workout) use (&$lowRepCount,&$minStepSetCount, $minStepId){
            if($workout->step_master_id === $minStepId){
                $minStepSetCount++;
                if($lowRepCount > $workout->count){
                    $lowRepCount = $workout->count;
                }
            }
        });

        $this->nextLevelWorkout = new Workout;
        $this->nextLevelWorkout->step_master_id = $minStepId;
        $this->nextLevelWorkout->menu_master_id = $this->workoutSetList->first()->menu_master_id;
        $this->nextLevelWorkout->count = $lowRepCount+1;

    }

    /**
     * @param $userId
     * @param $menuId
     * @return WorkoutSet|null
     */
    static public function getLastWorkoutSet($userId, $menuId)
    {
        $lastWorkout = Workout::where('user_id', '=', $userId)
            ->where('menu_master_id','=', $menuId)
            ->latest()
            ->first();
        if(!$lastWorkout) return null;

        if($lastWorkout->hasParent()){
            $workoutSetList = Workout::where([['user_id', '=', $userId], ['menu_master_id','=', $menuId],['parent_id',$lastWorkout->parent_id]])
                ->orwhere([['user_id', '=', $userId], ['menu_master_id','=', $menuId],['id', '=', $lastWorkout->parent_id]])
                ->get();
        }
        else {
            $workoutSetList = collect([$lastWorkout]);
        }

        $workoutSet = new WorkoutSet;
        $workoutSet->setWorkoutList($workoutSetList);

        return $workoutSet;
    }

    /**
     * @param Collection $workoutSetList
     */
    private function setWorkoutList(Collection $workoutSetList)
    {
        $this->workoutSetList = $workoutSetList;
    }
}
