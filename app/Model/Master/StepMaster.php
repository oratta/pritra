<?php

namespace App\Model\Master;

use App\Model\Entity\WorkoutLevel;
use Illuminate\Database\Eloquent\Model;

class StepMaster extends Model
{
    protected $table = 'step_masters';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function menu()
    {
        return $this->belongsTo('App\Model\Master\MenuMaster', 'menu_master_id');
    }

    public function getImgUrl()
    {
        return "";
    }

    /**
     * @return WorkoutLevel
     */
    public function getNextLevel($repCount, $setCount = 0)
    {
        $nextRepCount = 0;
        $nextWorkoutCount = 0;
        if($repCount < $this->set1_start_count){
            return $this->getBeforeLastLevel();
        }
        else if($repCount < $this->set2_start_count){
            $nextRepCount = $repCount+1;
            $nextWorkoutCount = 1;
        }
        else if($repCount < $this->set3_start_count){

            $nextRepCount = $repCount+1;
            $nextWorkoutCount = 2;
        }
        else if($this->set3_start_count <= $repCount){
            if($this->set3_master_count != 0 && $repCount < $this->set3_master_count){
                $nextRepCount = $repCount+1;
                $nextWorkoutCount = 3;
            }
            else {
                return $this->getNextFirstLevel();
            }
        }

        return new WorkoutLevel(['stepId' => $this->id, 'repCount' => $nextRepCount, 'setCount' => $nextWorkoutCount]);
    }

    private function getBeforeLastLevel()
    {
        $before = $this->getBefore();
        if(!$before) return null;
        if($before->set3_maser_count === 0){
            return new WorkoutLevel(['stepId' => $before->id, 'repCount' => $before->set3_start_count, 'setCount'=>2]);
        }
        else {
            return new WorkoutLevel(['stepId' => $before->id, 'repCount' => $before->set3_master_count, 'setCount' => 3]);
        }

    }
    private function getNextFirstLevel()
    {
        $next = $this->getNext();
        if(!$next) return null;
        return new WorkoutLevel(['stepId' => $next->id, 'repCount' => $next->set1_start_count, 'setCount' => 1]);

    }

    private function getBefore()
    {
        if($this->step_number === 1){
            return null;
        }
        return StepMaster::where([['menu_master_id', '=', $this->menu_master_id],['step_number', '=', $this->step_number - 1]])
            ->first();
    }
    private function getNext()
    {
        if($this->step_number === 10){
            return null;
        }
        return StepMaster::where([['menu_master_id', '=', $this->menu_master_id],['step_number', '=', $this->step_number +1]])
            ->first();
    }
}
