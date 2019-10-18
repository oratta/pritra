<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class MenuMaster extends Model
{
    const MASTER_COUNT = 6;

    protected $table = 'menu_masters';
    public $timestamps = true;

    public function steps()
    {
        return $this->hasMany('App\Model\Master\StepMaster');
    }

    public function getImgUrl()
    {
        return "";
    }
}
