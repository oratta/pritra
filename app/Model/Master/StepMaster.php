<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class StepMaster extends Model
{
    protected $table = 'step_masters';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function menu()
    {
        return $this->belongsTo('App\Model\Master\MenuMaster');
    }

    public function getImgUrl()
    {
        return "";
    }
}
