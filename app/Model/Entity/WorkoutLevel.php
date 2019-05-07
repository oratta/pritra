<?php

namespace App\Model\Entity;

use Illuminate\Database\Eloquent\Model;

class WorkoutLevel extends Model
{
//    protected $stepNumber;
//    protected $stepId;
//    protected $repCount;
//    protected $setCount;
    protected $guarded = ['id'];

    public function step()
    {
        return $this->belongsTo('App\Model\Master\StepMaster','stepId');
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
            return new WorkoutLevel(['stepId' => $this->step->id, 'repCount' => $levelInfo["repCount"], "setCount" => $levelInfo["setCount"]]);
        }
    }

    private function getBeforeStepLastLevel()
    {
        $beforeStep = $this->step->getBefore();
        if(!$beforeStep) return null;
        return new WorkoutLevel(['stepId' => $beforeStep->id, 'repCount' => $beforeStep->level3_rep_count, 'setCount'=>$beforeStep->level3_set_count]);
    }
    private function getNextStepFirstLevel()
    {
        $nextStep = $this->step->getNext();
        if(!$nextStep) return null;
        return new WorkoutLevel(['stepId' => $nextStep->id, 'repCount' => $nextStep->level1_rep_count, 'setCount' => $nextStep->level2_set_count]);
    }

}
