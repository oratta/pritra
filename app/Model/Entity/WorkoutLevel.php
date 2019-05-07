<?php

namespace App\Model\Entity;

use Illuminate\Database\Eloquent\Model;

class WorkoutLevel extends Model
{
    private $stepNumber;
    private $stepId;
    private $repCount;
    private $setCount;
    protected $guarded = ['id'];

    public function step()
    {
        return $this->belongsTo('App\Model\Master\StepMaster','stepId');
    }

    public function getNextLevel()
    {
        return $this->step->getNextLevel($this->getAttribute('repCount'), $this->getAttribute('setCount'));
    }


}
