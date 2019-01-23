<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    public $timestamps = false;

    /**
     * Many event created to one user relation.
     *
     * @return $this
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'creator');
    }

    /**
     * Many event join requeest to one user relation.
     *
     * @return $this
     */
    public function userRequest()
    {
        return $this->belongsToMany('App\User', 'req', 'eventid', 'userid')
            ->withPivot('status');
    }

    /**
     * Many event to one subject relation.
     *
     * @return $this
     */
    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subid');
    }


    /**
     * One event to many question relation.
     *
     * @return $this
     */
    public function queans()
    {
        return $this->hasMany('App\Queans', 'eventid');
    }
}
