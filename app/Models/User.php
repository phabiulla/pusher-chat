<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nick', 'age', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = array("avatar_url");

    public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    public function getAvatarUrlAttribute(){
        if($this->image) {
            return $this->image;
        } else {
            return "http://placehold.it/50/55C1E7/fff&text=". strtoupper($this->name[0]);
        }
    }
}
