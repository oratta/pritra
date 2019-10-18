<?php

namespace App\Model\UserData;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'work_outs';
    protected $guarded = ['id','user_id'];
    public $timestamps = true;
    private $savedWorkoutSet;

    protected $attributes = [
        'parent_id' => -1,
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\UserData\User');
    }

    public function menu()
    {
        return $this->belongsTo('App\Model\Master\MenuMaster', 'menu_master_id');
    }

    public function step()
    {
        return $this->belongsTo('App\Model\Master\StepMaster','step_master_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Model\UserData\Workout', 'parent_id');
    }

    public function workoutSet()
    {
        return $this->belongsTo('App\Model\UserData\WorkoutSet', 'workout_set_id');
    }

    public function hasParent()
    {
        return $this->parent_id > 0 ? true : false;
    }

    public function save(array $options = [])
    {
        if(!$this->workout_set_id){
            $this->setWorkoutSet();
        }
        if($this->paret_id === -1) throw new \Exception("set parent_id before to save a Workout instance");
        return parent::save($options);
    }


    public function setParentId()
    {
        $parentId = 0;
        $latestWorkout = Workout::select('id','parent_id', 'created_at')
            ->where([['user_id','=', $this->getAttribute('user_id')],['menu_master_id','=',$this->menu_master_id]])
            ->latest()
            ->first();

        if($latestWorkout && $latestWorkout->isNowWorkoutSet()){
            if($latestWorkout->getAttribute('parent_id')){
                $parentId = $latestWorkout->getAttribute('parent_id');
            }else {
                $parentId = $latestWorkout->id;
            }
        }

        $this->parent_id = $parentId;
    }

    public function setWorkoutSetAttribute(WorkoutSet $workoutSet)
    {
        $this->relations['workoutSet'] = $workoutSet;
    }

    /**
     */
    public function setWorkoutSet()
    {
        if($this->parent_id === -1) throw new \Exception("don't call this function before setParentId");

        if($this->parent_id !== 0){
            $this->parent->workoutSet->addWorkout($this);
            $this->parent->workoutSet->save();
            $this->workoutSet()->associate($this->parent->workoutSet);
        }
        else{
            $workoutSet = new WorkoutSet(
                [
                    'user_id' => $this->user_id,
                    'menu_master_id' => $this->menu_master_id,
                ]
            );
            $workoutSet->addWorkout($this);
            $workoutSet->save();
            $this->workoutSet()->associate($workoutSet);
        }
    }

    /**
     * @param $latestWorkoutTime
     * @return bool
     */
    private function isNowWorkoutSet()
    {
        $now = Carbon::now();
        $latestTime = new Carbon($this->created_at);
        $diffMin = $now->diffInMinutes($latestTime);

        return $diffMin < config('pritra.WORKOUT_SET_TERM_MIN');
    }

    /***
     * 最後のワークアウトのログをメニューごとのリストとして返す
     * @return Collection
     */
    public static function getLastLogList($userId)
    {
        $lastLogList = [];

        for ($menuId = 1; $menuId <= config('pritra.MENU_COUNT'); ++$menuId) {
            $workout = Workout::select('menu_master_id', 'step_master_id', 'count', 'difficulty_type', 'created_at')
                                    ->where('menu_master_id','=', $menuId)
                                    ->where('user_id', '=', $userId)
                                    ->latest()
                                    ->first();
            $lastLogList[$menuId] = $workout ? $workout : null;
        }

        return $lastLogList;
    }
}
