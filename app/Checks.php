<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checks extends Model
{
    protected $table = "checks";
    
    protected $fillable = ['app_id', 'status', 'enabled', 'last_run_message', 'last_run_output', 'next_run_in_minutes'];

    function admin(){
        return $this->belongsTo('App\App', 'app_id');
    }
}
