<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
    protected $fillable = [
        'id', 'visiting_controller', 'last_login', 'group'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token'
    ];

    /**
     * Link to handover data
     * 
     * @return \App\Handover
     */
    public function handover(){
        return $this->belongsTo(Handover::class, 'id');
    }

    /**
     * Link user's endorsement
     * 
     * @return \App\Solo
     */
    public function solo_endorsement(){
        return $this->hasOne(Solo::class);
    }

    public function trainings(){
        return $this->hasMany(Training::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function teaches(){
        return $this>belongsTo(Training::class);
    }
}
