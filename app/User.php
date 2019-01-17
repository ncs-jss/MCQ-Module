<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    public $timestamps = false;

    public function event()
    {
        return $this->hasMany('App\Event', 'creator');
    }

    public function eventRequest()
    {
        return $this->belongsToMany('App\Event', 'req', 'userid', 'eventid')->withPivot('status');
    }

    public function response()
    {
        return $this->hasMany('App\Response', 'userid');
    }

    public function queResponse()
    {
        return $this->belongsToMany('App\Queans', 'response', 'userid', 'queid')->withPivot('ans');
    }
}
