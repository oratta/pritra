<?php

namespace App\Model\UserData;

use App\Model\Master\MenuMaster;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class WorkoutSet extends Model
{
    protected $table = "workout_sets";
    protected $guarded = ["id"];
    public $timestamps = true;

    /*
     * default value for eloquent
     */
    protected $attributes = [
        'min_step_master_id'    => 0,
        'min_rep_count'         => 0,
        'set_count'             => 0,
        'level'                 => 0,
    ];

    protected $casts = [
        'user_id'       => 'int',
        'is_plan'       => 'int',
    ];

    /**
     * @var Workout
     */
    public $nextLevelWorkout;

    public function menu()
    {
        return $this->belongsTo('App\Model\Master\MenuMaster','menu_master_id');
    }

    public function step()
    {
        return $this->belongsTo('App\Model\Master\StepMaster','min_step_master_id');
    }

    public function workouts()
    {
        return $this->hasMany('App\Model\UserData\Workout');
    }

    public function getStartTimeAttribute($value)
    {
        if(!$value) {
            $this->setStartTime();
        }

        return $value;
    }

    private function setStartTime()
    {
        if($this->workouts->first() instanceof Workout && $this->workouts->first()->created_at){
            $this->start_time = $this->workouts->first()->created_at;
        }else {
            $this->start_time = now();
        }
    }

    public function getEndTimeAttribute($value)
    {
        if(!$value) {
            $this->setEndTime();
        }
        return $value;
    }

    private function setEndTime()
    {
        if($this->workouts->last() instanceof Workout && $this->workouts->last()->created_at){
            $this->end_time = $this->workouts->last()->created_at;
        }
        else {
            $this->end_time = now();
        }
    }

    public function setWorkoutsAttribute(Collection $workouts)
    {
        $this->relations['workouts'] = $workouts;
    }

    public static function createplannedWorkoutSet($menuMasterId,$stepMasterId, $plannedRepCount, $plannedSetCount)
    {
        $workoutSet = new WorkoutSet;
        $workoutSet->menu_master_id         = $menuMasterId;
        $workoutSet->min_step_master_id     = $stepMasterId;
        $workoutSet->is_plan                = true;
        $workoutSet->planned_min_rep_count   = $plannedRepCount;
        $workoutSet->planned_set_count       = $plannedSetCount;
        $workoutSet->step_level             = 0;
        $workoutSet->setLevel(true);

        return $workoutSet;
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

        return collect($bestLogList);
    }

    static public function getRecentWorkoutSetList($userId, $limit=1)
    {
        $recent_l = [];
        for ($menuId = 1; $menuId <= config('pritra.MENU_COUNT'); ++$menuId) {
            $recent_l[$menuId] = static::getRecentWorkoutSet($userId, $menuId, $limit);
        }
        return collect($recent_l);
    }

    static private function getRecentWorkoutSet($userId, $menuId, $limit=1)
    {
        $workoutSet_l = WorkoutSet::where('user_id', '=', $userId)
            ->where('menu_master_id', '=', $menuId)
            ->limit($limit)
            ->get();
        return $workoutSet_l;
    }



    public function setWorkoutSetInfo(){
        $minStepId = $this->workouts->min('step_master_id');
        $lowRepCount = 1000;
        $minWorkoutCount = 0;
        $this->workouts->each(function($workout) use (&$lowRepCount,&$minWorkoutCount, $minStepId){
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
        $this->setStartTime();
        $this->setEndTime();
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
        if(!$workoutSet) {
            return new WorkoutSet(
                [
                    'user_id' => $userId,
                    'menu_master_id' => $menuId,
                    'min_step_master_id' => MenuMaster::getFirstStepMasterId($menuId),
                    'min_rep_count' => 0,
                    'end_time' => now(),
                    'start_time' => now(),
                    'set_count' => 0,
                    'level' => 0,
                    'step_level' => 0
                ]
            );
        }
        return $workoutSet;
    }

    public function addWorkout(Workout $workout)
    {
        $workoutList = $this->workouts;
        $workoutList->add($workout);
        $this->workouts = $workoutList;
        $this->setWorkoutSetInfo();
    }

    public function addWorkoutBulk(array $workoutInfo_l)
    {
        $minCount = PHP_INT_MAX;
        $workoutList = $this->workouts;
        foreach ($workoutInfo_l as $workoutInfo){
            $workout = new Workout();
            $workout->workout_set_id    = $this->id;
            $workout->user_id           = $this->user_id;
            $workout->menu_master_id    = $this->menu_master_id;
            $workout->step_master_id    = $this->min_step_master_id;
            $workout->count             = $workoutInfo['repCount'];
            $workout->difficulty_type   = $workoutInfo['difficultyType'];
            $workoutList->add($workout);
        }
        $this->workouts = $workoutList;
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
    public function setLevel($isPlan=false)
    {
        if ($isPlan){
            $columnPrefix = "planned_";
        }else {
            $columnPrefix = "";
        }
        if($this->step && $this->{$columnPrefix . "min_rep_count"} && $this->{$columnPrefix . "set_count"}){
            $this->{$columnPrefix . "level"} = $this->step->getAchievedLevel($this->{$columnPrefix . "min_rep_count"}, $this->{$columnPrefix . "set_count"});
            if (!$isPlan) $this->step_level = $this->min_step_master_id*100+$this->level;
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
        else if ($achievedLevel === 0 && $this->step->getBefore()){
            // the one before steps max level
            return $this->getBeforeStepLastLevel();
        }
        else {
            // same step next level
            $levelInfo = $this->step->getLevelInfo($achievedLevel+1);
            $workoutSet = new WorkoutSet(['min_step_master_id' => $this->step->id, 'min_rep_count' => $levelInfo["repCount"], "set_count" => $levelInfo["setCount"]]);
            $workoutSet->setLevel();

            return $workoutSet;
        }
    }

    private function getFirstLevel()
    {

    }

    private function getBeforeStepLastLevel()
    {
        $beforeStep = $this->step->getBefore();
        if(!$beforeStep) return null;
        $workoutSet = new WorkoutSet(['min_step_master_id' => $beforeStep->id, 'min_rep_count' => $beforeStep->level3_rep_count, 'set_count'=>$beforeStep->level3_set_count]);
        $workoutSet->setLevel();

        return $workoutSet;
    }
    private function getNextStepFirstLevel()
    {
        $nextStep = $this->step->getNext();
        if(!$nextStep) return null;
        $workoutSet = new WorkoutSet(['min_step_master_id' => $nextStep->id, 'min_rep_count' => $nextStep->level1_rep_count, 'set_count' => $nextStep->level2_set_count]);
        $workoutSet->setlevel();

        return $workoutSet;
    }

    public function getProgressLevel($isText=false)
    {

        if($this->id){
            //10step 3level = 100%
            //(step -1)*10 + level*3
            if($isText){
                return "step".$this->step->step_number.": level".$this->level;
            }
            else{
                return ($this->step->step_number -1)*10 + $this->level * 3;
            }
        }
        else {
            if($isText){
                return "no workouts";
            }
            else{
                return 0;
            }
        }
    }

    public function isPlan()
    {
        if($this->is_plan){
            return true;
        }
        else {
            return false;
        }
    }

}
