<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class MenuMaster extends Model
{
    protected $table = 'menu_masters';
    public $timestamps = true;

    public function steps()
    {
        return $this->hasMany('App\Step');
    }

    public function getImgUrl()
    {
        return "";
    }
}
