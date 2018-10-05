<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOut extends Model
{
    protected $table = 'work_outs';
    protected $guarded = ['id','user_id'];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
