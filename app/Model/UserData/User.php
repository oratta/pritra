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

    public function getBestWorkoutSets()
    {
        return WorkoutSet::getBestWorkoutSetList($this->id);
    }

    public function getRecommendedWorkoutSets()
    {
        $recommendWorkoutSets = $this->getBestWorkoutSets()->map(function($workoutSet){
            return $workoutSet->getNextLevelWorkoutSets();
        });

        return $recommendWorkoutSets;
    }
}
