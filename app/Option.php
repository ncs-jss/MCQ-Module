<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'option';
    public $timestamps = false;

    /**
     * Many options to one question relation.
     *
     * @return $this
     */
    public function queans()
    {
        return $this->belongsTo('App\Queans', 'queid');
    }
}
