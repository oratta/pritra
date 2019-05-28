<?php

namespace App\Model\UserData;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class WorkoutSet extends Model
{
    protected $table = "workout_sets";
    protected $guarded = ["id"];
    public $timestamps = true;
    private $cache = [];
    private $workoutList;

    /**
     * @var Workout
     */
    public $nextLevelWorkout;


    public function step()
    {
        return $this->belongsTo('App\Model\Master\StepMaster','min_step_master_id');
    }

    public function getWorkoutList($isForce = false)
    {
        if($isForce || !$this->workoutList){
            $workoutIdList = explode(",",$this->workout_ids);
            $workoutList = Workout::with('step', 'menu')
                ->whereIn('id', $workoutIdList)->get();
            $this->workoutList = $workoutList;
        }

        return $this->workoutList;
    }

    public function setWorkoutList(Collection $workoutList)
    {
        $this->workoutList = $workoutList;
    }


    public function getStartTime()
    {
        if(!$this->start_time) {
            $this->start_time = $this->getWorkoutList()->first()->created_at;
        }

        return $this->start_time;
    }

    public function getEndTime()
    {
        if(!$this->end_time) {
            $this->end_time = $this->getWorkoutList()->last()->created_at;
        }
        return $this->end_time;
    }

    /**
     * @return array
     */
    public function getWorkoutArray()
    {
        return $this->getWorkoutList()->all();
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

    /**
     * @param $userId
     * @return array
     */
    static public function getBestWorkoutSetList($userId)
    {
        $bestLogList = [];

        for ($menuId = 1; $menuId <= config('pritra.MENU_COUNT'); ++$menuId) {
            $bestLogList[$menuId] = static::getBestWorkoutSet($userId, $menuId);
        }

        return $bestLogList;
    }



    private function setWorkoutSetInfo(){
        $minStepId = $this->getWorkoutList()->min('step_master_id');
        $lowRepCount = 1000;
        $minWorkoutCount = 0;
        $this->getWorkoutList()->each(function($workout) use (&$lowRepCount,&$minWorkoutCount, $minStepId){
            if($workout->step_master_id === $minStepId){
                $minWorkoutCount++;
                if($lowRepCount > $workout->count){
                    $lowRepCount = $workout->count;
                }
            }
        });
        if($lowRepCount === 1000 && $minWorkoutCount === 0){
            throw new \Exception("error to set WorkoutSetInfo");
        }
        $this->min_step_master_id = $minStepId;
        $this->min_rep_count = $lowRepCount;
        $this->set_count = $minWorkoutCount;
        $this->setLevel();
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
        $workoutSet = WorkoutSet::where('user_id', '=', $userId)
                ->where('menu_master_id', '=', $menuId)
                ->latest()
                ->first();
        if(!$workoutSet) return null;
        return $workoutSet;
    }

    /**
     * @param $userId
     * @param $menuId
     * @return WorkoutSet|null
     */
    static public function getBestWorkoutSet($userId, $menuId)
    {
        $workoutSet = WorkoutSet::where('user_id', '=', $userId)
            ->where('menu_master_id', '=', $menuId)
            ->orderBy('step_level', 'desc')
            ->first();
        if(!$workoutSet) return null;
        return $workoutSet;
    }

    public function addWorkout(Workout $workout)
    {
        $workoutList = $this->getWorkoutList();
        $workoutList->add($workout);
        $this->setWorkoutList($workoutList);
        $this->setWorkoutSetInfo();
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
        if($this->step && $this->min_rep_count && $this->set_count){
            $this->level = $this->step->getAchievedLevel($this->min_rep_count, $this->set_count);
            $this->step_level = $this->min_step_master_id*100+$this->level;
            return true;
        }
        return false;
    }



    public function getNextLevel()
    {
        $achievedLevel = $this->step->getAchievedLevel($this->min_rep_count, $this->set_count);

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
            return new WorkoutSet(['min_step_master_id' => $this->step->id, 'min_rep_count' => $levelInfo["repCount"], "set_count" => $levelInfo["setCount"]]);
        }
    }

    private function getBeforeStepLastLevel()
    {
        $beforeStep = $this->step->getBefore();
        if(!$beforeStep) return null;
        return new WorkoutSet(['min_step_master_id' => $beforeStep->id, 'min_rep_count' => $beforeStep->level3_rep_count, 'set_count'=>$beforeStep->level3_set_count]);
    }
    private function getNextStepFirstLevel()
    {
        $nextStep = $this->step->getNext();
        if(!$nextStep) return null;
        return new WorkoutSet(['min_step_master_id' => $nextStep->id, 'min_rep_count' => $nextStep->level1_rep_count, 'set_count' => $nextStep->level2_set_count]);
    }

}
