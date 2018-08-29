<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    public $timestamps = true;

    public function steps()
    {
        return $this->hasMany('App\Record');
    }
}
