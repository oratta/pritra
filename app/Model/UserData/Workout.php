<?php

namespace App\Model\UserData;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'work_outs';
    protected $guarded = ['id','user_id'];
    public $timestamps = true;

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

    public function hasParent()
    {
        return $this->parent_id ? true : false;
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $this->setAttribute('parent_id',$this->getParentId());
        return parent::save($options);
    }

    /**
     * @param $userId
     * @return int parent_id||null
     */
    private function getParentId()
    {
        $latestWorkout = Workout::select('id','parent_id', 'created_at')
            ->where('user_id','=', $this->getAttribute('user_id'))
            ->latest()
            ->first();

        if($latestWorkout && $latestWorkout->isNowWorkoutSet()){
            //join work out
            if($latestWorkout->getAttribute('parent_id')){
                return $latestWorkout->getAttribute('parent_id');
            }else {
                return $latestWorkout->id;
            }
        }
        else {
            //create workout set
            return 0;
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
