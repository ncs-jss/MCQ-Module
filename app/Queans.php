<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queans extends Model
{
    protected $table = 'queans';
    public $timestamps = false;

    public function option()
    {
    	return $this->hasMany('App\Option', 'queid');
    }

    public function userResponse()
    {
    	return $this->belongsToMany('App\User', 'response', 'queid', 'userid')->withPivot('ans');
    }

    public function event()
    {
    	return $this->belongsTo('App\Event', 'eventid');
    }
}
