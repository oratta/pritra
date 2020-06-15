<?php

namespace App\Model\UserData;

use App\Model\Master\MenuMaster;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type===1 ? true : false;
    }

    public function getBestWorkoutSet($menuId)
    {
        return WorkoutSet::getBestWorkoutSet($this->id, $menuId);
    }

    public function getBestWorkoutSets()
    {
        return WorkoutSet::getBestWorkoutSetList($this->id);
    }

    public function getRecommendedWorkoutSets()
    {
        $recommendWorkoutSets = $this->getBestWorkoutSets()->map(function(WorkoutSet $workoutSet){
            return $workoutSet->getNextLevel();
        });

        return $recommendWorkoutSets;
    }

    public function getRecentWorkoutSet_l($limit=1)
    {
        return WorkoutSet::getRecentWorkoutSetList($this->id);
    }

    public function createPlanedWorkoutSet($menuMasterId,$stepMasterId, $planedRepCount, $planedSetCount)
    {
        $workoutSet = WorkoutSet::createPlanedWorkoutSet($menuMasterId,$stepMasterId, $planedRepCount, $planedSetCount);
        $workoutSet->user_id = $this->id;
        return $workoutSet;
    }

    public function getPlan_l()
    {
        return WorkoutSet::where(['user_id'=>$this->id, 'is_plan'=>1])->
                    get()->keyBy('menu_master_id');
    }

    public function hasPlan()
    {
        return $this->getPlan_l()->count() === 0 ? false : true;
    }
}
