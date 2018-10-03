<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $table = 'steps';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }

    public function getImgUrl()
    {
        return "";
    }
}
