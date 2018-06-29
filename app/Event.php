<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo('App\User', 'creator');
    }

    public function userRequest()
    {
    	return $this->belongsToMany('App\User', 'req', 'eventid', 'userid')->withPivot('status');
    }

    public function subject()
    {
    	return $this->belongsTo('App\Subject', 'subid');
    }

    public function queans()
    {
    	return $this->hasMany('App\Queans', 'eventid');
    }
}
