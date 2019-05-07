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
    public function getAchievedLevel($repCount, $setCount = 0)
    {
        $nextRepCount = 0;
        $nextWorkoutCount = 0;

        $levelNum = 0;
        for ($i = 0; $i < 3; ++$i) {
            $levelNum = $i + 1;
            $isAchieved = $this->isAchieved($levelNum, $repCount, $setCount);
            if (!$isAchieved) {
                $levelNum--;
                break;
            }
        }
        return $levelNum;
    }

    public function getLevelInfo($level)
    {
        $repCountColumn = "level" . $level . "_rep_count";
        $setCountColumn = "level" . $level . "_set_count";
        return ["repCount" => $this->$repCountColumn, "setCount" => $this->$setCountColumn];
    }

    private function isAchieved($levelNum, $repCount, $setCount){
        $repCountColumnName = "level" . $levelNum . "_rep_count";
        $setCountColumnName = "level" . $levelNum . "_set_count";
        if($this->$repCountColumnName  <= $repCount && $this->$setCountColumnName <= $setCount ){
            return true;
        }
        else{
            return false;
        }
    }

    public function getBefore()
    {
        if($this->step_number === 1){
            return null;
        }
        return StepMaster::where([['menu_master_id', '=', $this->menu_master_id],['step_number', '=', $this->step_number - 1]])
            ->first();
    }
    public function getNext()
    {
        if($this->step_number === 10){
            return null;
        }
        return StepMaster::where([['menu_master_id', '=', $this->menu_master_id],['step_number', '=', $this->step_number +1]])
            ->first();
    }
}
