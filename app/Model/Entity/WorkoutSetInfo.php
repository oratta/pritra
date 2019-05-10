<?php

namespace App\Model\Entity;

use Illuminate\Database\Eloquent\Model;

class WorkoutSetInfo extends Model
{
//    protected $stepId;
//    protected $repCount;
//    protected $setCount;
    protected $guarded = ['id'];
    private $level = null;

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
        if($this->step && $this->repCount && $this->setCount){
            $this->level = $this->step->getAchievedLevel($this->repCount, $this->setCount);
            return true;
        }
        return false;
    }


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
            return new WorkoutSetInfo(['stepId' => $this->step->id, 'repCount' => $levelInfo["repCount"], "setCount" => $levelInfo["setCount"]]);
        }
    }

    private function getBeforeStepLastLevel()
    {
        $beforeStep = $this->step->getBefore();
        if(!$beforeStep) return null;
        return new WorkoutSetInfo(['stepId' => $beforeStep->id, 'repCount' => $beforeStep->level3_rep_count, 'setCount'=>$beforeStep->level3_set_count]);
    }
    private function getNextStepFirstLevel()
    {
        $nextStep = $this->step->getNext();
        if(!$nextStep) return null;
        return new WorkoutSetInfo(['stepId' => $nextStep->id, 'repCount' => $nextStep->level1_rep_count, 'setCount' => $nextStep->level2_set_count]);
    }

}
