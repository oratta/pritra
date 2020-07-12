<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class StepMaster extends Model
{
    const MASTER_COUNT = 60;
    const STEP_NUMBER_MAX = 10;
    protected $table = 'step_masters';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function menu()
    {
        return $this->belongsTo('App\Model\Master\MenuMaster', 'menu_master_id');
    }

    public function getImageUrl()
    {
        return "/image/step/" . $this->menu_master_id . "/" . $this->menu_master_id . "-" . $this->step_number . "-" . "1.png";
    }

    //TODO 表示する際のnameにnumberを付ける : S1:Wall Push Up

    /**
     */
    public function getAchievedLevel($repCount, $set = 0)
    {
        $nextRepCount = 0;
        $nextWorkoutCount = 0;

        $levelNum = 0;
        for ($i = 0; $i < 3; ++$i) {
            $levelNum = $i + 1;
            $isAchieved = $this->isAchieved($levelNum, $repCount, $set);
            if (!$isAchieved) {
                $levelNum--;
                break;
            }
        }
        return $levelNum;
    }

    public function getLevelInfo($level=0)
    {
        if($level === 0){
            $levelInfo_l = [];
            for($i=1;$i<=3;++$i) {
                $levelInfo_l[] = $this->getLevelInfo($i);
            }
            return $levelInfo_l;
        }
        else {
            $repCountColumn = "level" . $level . "_rep_count";
            $setCountColumn = "level" . $level . "_set_count";
            return ["level" => $level, "repCount" => $this->$repCountColumn, "setCount" => $this->$setCountColumn];
        }
    }

    /***
     * all menu, all step's level list
     * @return array
     */
    static public function getLevelInfo_l_l()
    {
        $levelInfo_l = [];
        for($i=1; $i<=config("pritra.MENU_COUNT"); ++$i){
            $levelInfo_l[$i] = self::getLevelInfo_l($i);
        }
        return $levelInfo_l;
    }

    static public function getLevelInfo_l($menuId)
    {
        $levelInfo_l = [];
        $step_l = StepMaster::getStep_lByMenuId($menuId);
        foreach($step_l as $step){
            $levelInfo_l[$step->id] = $step->getLevelInfo();
        }

        return $levelInfo_l;
    }

    /**
     * all menu, all step's info
     * @return array
     */
    static public function getInfo_l_l()
    {
        $stepInfo_l = [];
        for($i=1; $i<=config("pritra.MENU_COUNT"); ++$i){
            $stepInfo_l[$i] = self::getInfo_l($i);
        }
        return $stepInfo_l;
    }

    static public function getInfo_l($menuId)
    {
        $step_l = StepMaster::getStep_lByMenuId($menuId);
        $stepInfo_l = [];
        foreach($step_l as $step){
            $stepInfo_l[$step->id] = [];
            $stepInfo_l[$step->id]['name'] = $step->name;
            $stepInfo_l[$step->id]['lvInfo'] = $step->getLevelInfo_l();
        }

        return $stepInfo_l;
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

    static public function getStep_lByMenuId($menuId)
    {
        return StepMaster::where('menu_master_id', $menuId)->get();
    }

    public function getViewName()
    {
        return $this->step_number . "-" . $this->name;
    }

    public function setViewName()
    {
        $this->name =  $this->getViewName();
    }

}
