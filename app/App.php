<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table = "webapps";
    
    protected $fillable = ['name', 'url', 'admin_id'];

    function admin(){
        return $this->belongsTo('App\Admin', 'admin_id');
    }
}
