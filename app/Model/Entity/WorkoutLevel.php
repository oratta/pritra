<?php

namespace App\Model\Entity;

use Illuminate\Database\Eloquent\Model;

class WorkoutLevel extends Model
{
    private $stepNumber;
    private $stepId;
    private $repCount;
    private $workoutCount;
    protected $guarded = ['id'];

    public function step()
    {
        return $this->belongsTo('App\Model\Master\StepMaster','stepId');
    }

    public function getNextMilestone()
    {
        return $this->step->getNextMilestone($this->getAttribute('repCount'), $this->getAttribute('workoutCount'));
    }


}
