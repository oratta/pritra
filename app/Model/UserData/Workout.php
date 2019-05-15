<?php

namespace App\Model\UserData;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'work_outs';
    protected $guarded = ['id','user_id'];
    public $timestamps = true;
    protected $workoutSet;

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
        if(!$this->workout_set_id) throw new \Exception("set workout_set_id before to save Workout");
        if($this->paret_id === -1) throw new \Exception("set parent_id before to save a Workout inctance");
        return parent::save($options);
    }


    public function setParentId()
    {
        $parentId = 0;
        $latestWorkout = Workout::select('id','parent_id', 'created_at')
            ->where('user_id','=', $this->getAttribute('user_id'))
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


    /**
     * TODO check that set default parent id = -1
     */
    public function setWorkoutSet()
    {
        if($this->parent_id === -1) throw new \Exception("don't call this function before setParentId");

        if($this->parent_id !== 0){
            $this->workoutSet = $this->parent->workoutSet;
            $this->workoutSet->addWorkout($this);
        }
        else{
            $this->workoutSet = new WorkoutSet();
            $this->workoutSet->user_id = $this->user_id;
            $this->workoutSet->menu_master_id = $this->menu_master_id;
            $this->workoutSet->workout_ids = "{$this->id}";
            $this->workoutSet->start_time = now();
            $this->workoutSet->end_time = now();
            $this->workoutSet->min_step_master_id = $this->step_master_id;
            $this->workoutSet->min_rep_count = $this->count;
            $this->workoutSet->set_count = 1;
            if(!$this->workoutSet->setLevel()) throw new \Exception("fail to Workout::setLevel");
        }
    }

    public function saveWorkoutSet()
    {
        $this->workoutSet->save();
        $this->workout_set_id = $this->workoutSet->id;
    }

    public function saveWorkoutIdToWorkoutSet()
    {
        $this->workoutSet->workout_ids = "{$this->id}";
        $this->workoutSet->save();
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
