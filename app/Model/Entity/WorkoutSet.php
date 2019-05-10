<?php

namespace App\Model\Entity;

use App\Model\UserData\Workout;
use App\Model\Entity\WorkoutSetInfo;
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

    //    protected $stepId;
    //    protected $repCount;
    //    protected $setCount;
    protected $guarded = ['id'];
    private $level = null;


    /**
     * @var Workout
     */
    public $nextLevelWorkout;


    public function step()
    {
        return $this->belongsTo('App\Model\Master\StepMaster','stepId');
    }


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
            if($lastWorkout instanceof  WorkoutSet)$lastWorkout->setNextWorkoutSetInfo();
            $lastLogList[$menuId] = $lastWorkout;
        }

        return $lastLogList;
    }

    private function setWorkoutSetInfo(){
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
        $this->stepId = $minStepId;
        $this->repCount = $lowRepCount;
        $this->setCount = $minWorkoutCount;
    }

    private function setNextWorkoutSetInfo(){
        $this->setWorkoutSetInfo();
        $this->nextLevelWorkout = $this->getNextLevel();
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

    /***********************************
     * ここから移植
     ***********************************/

    /**
     * return achieved level
     * @return null
     */
    public function getLevel()
    {
        if (!$this->level) $this->setLevel();
        return $this->level;
    }

    /**
     * @return bool if fail to set level property, it return false
     */
    public function setLevel()
    {
        if($this->step && $this->repCount && $this->setCount){
            $this->level = $this->step->getAchievedLevel($this->repCount, $this->setCount);
            return true;
        }
        return false;
    }



    public function getNextLevel()
    {
        $achievedLevel = $this->step->getAchievedLevel($this->repCount, $this->setCount);

        if($achievedLevel === config("pritra.MAX_LEVEL")){
            // next step first level
            return $this->getNextStepFirstLevel();
        }
        else if ($achievedLevel === 0){
            // the one before steps max level
            return $this->getBeforeStepLastLevel();
        }
        else {
            // same step next level
            $levelInfo = $this->step->getLevelInfo($achievedLevel+1);
            return new WorkoutSet(['stepId' => $this->step->id, 'repCount' => $levelInfo["repCount"], "setCount" => $levelInfo["setCount"]]);
        }
    }

    private function getBeforeStepLastLevel()
    {
        $beforeStep = $this->step->getBefore();
        if(!$beforeStep) return null;
        return new WorkoutSet(['stepId' => $beforeStep->id, 'repCount' => $beforeStep->level3_rep_count, 'setCount'=>$beforeStep->level3_set_count]);
    }
    private function getNextStepFirstLevel()
    {
        $nextStep = $this->step->getNext();
        if(!$nextStep) return null;
        return new WorkoutSet(['stepId' => $nextStep->id, 'repCount' => $nextStep->level1_rep_count, 'setCount' => $nextStep->level2_set_count]);
    }
}
