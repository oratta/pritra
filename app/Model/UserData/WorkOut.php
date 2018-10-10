<?php

namespace App\Model\UserData;

use Illuminate\Database\Eloquent\Model;

class WorkOut extends Model
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

    /***
     * 最後のワークアウトのログをメニューごとのリストとして返す
     * @return Collection
     */
    public static function getLastLogList($userId)
    {
        $lastLogList = [];

        for ($menuId = 1; $menuId < config('pritra.MENU_COUNT'); ++$menuId) {
            $workOut = WorkOut::select('menu_master_id', 'step_master_id', 'count', 'difficulty_type', 'created_at')
                                    ->where('menu_master_id','=', $menuId)
                                    ->where('user_id', '=', $userId)
                                    ->latest()
                                    ->first();
            $lastLogList[$menuId] = $workOut ? $workOut : null;
        }

        return $lastLogList;
    }
}
