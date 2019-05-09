<?php

namespace App\Model\Entity;

use App\Model\UserData\Workout;
use App\Model\Entity\WorkoutLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class WorkoutSet extends Model
{
    /**
     * @var Collection
     */
    private $workoutList;

    private $startTime = null;
    private $finishTime = null;
    private $setCount = 0;

    /**
     * @var WorkoutLevel
     */
    private $workoutLevel = null;

    /**
     * @var Workout
     */
    public $nextLevelWorkout;

    public function getStartTime()
    {
        if(!$this->startTime) {
            $this->startTime = $this->workoutList->first()->created_at;
        }

        return $this->startTime;
    }

    public function getFinishTime()
    {
        if(!$this->finishTime) {
            $this->finishTime = $this->workoutList->last()->created_at;
        }
        return $this->finishTime;
    }

    /**
     * @return array
     */
    public function getWorkoutArray()
    {
        return $this->workoutList->all();
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
            if($lastWorkout instanceof  WorkoutSet)$lastWorkout->setNextWorkoutLevel();
            $lastLogList[$menuId] = $lastWorkout;
        }

        return $lastLogList;
    }

    private function setWorkoutLevel(WorkoutLevel $workoutLevel = null){
        if($workoutLevel){
            $this->workoutLevel = $workoutLevel;
        }
        else {
            $minStepId = $this->workoutList->min('step_master_id');
            $lowRepCount = 1000;
            $minWorkoutCount = 0;
            $this->workoutList->each(function($workout) use (&$lowRepCount,&$minWorkoutCount, $minStepId){
                if($workout->step_master_id === $minStepId){
                    $minWorkoutCount++;
                    if($lowRepCount > $workout->count){
                        $lowRepCount = $workout->count;
                    }
                }
            });
            $this->workoutLevel = new WorkoutLevel;
            $this->workoutLevel->stepId = $minStepId;
            $this->workoutLevel->repCount = $lowRepCount;
            $this->workoutLevel->setCount = $minWorkoutCount;
        }
    }

    private function setNextWorkoutLevel(){
        $this->setWorkoutLevel();
        $this->nextLevelWorkout = $this->getNextLevel();
    }

    /**
     * @param $stepId
     * @param $repCount
     * @param $setCount
     * @return WorkoutLevel
     */
    private function getNextLevel(){
        return $this->workoutLevel->getNextLevel();
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
            $workoutList = Workout::with('step', 'menu')
                ->where([['user_id', '=', $userId], ['menu_master_id','=', $menuId],['parent_id',$lastWorkout->parent_id]])
                ->orwhere([['user_id', '=', $userId], ['menu_master_id','=', $menuId],['id', '=', $lastWorkout->parent_id]])
                ->get();
        }
        else {
            $workoutList = collect([$lastWorkout]);
        }

        $workoutSet = new WorkoutSet;
        $workoutSet->setWorkoutList($workoutList);


        return $workoutSet;
    }

    /**
     * @param Collection $workoutList
     */
    private function setWorkoutList(Collection $workoutList)
    {
        $this->workoutList = $workoutList;
    }
}
