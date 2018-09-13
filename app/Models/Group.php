<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'description', 'image'];
    protected $appends = array("banner_url");

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function hasUser($user_id)
    {
        foreach ($this->users as $user) {
            if($user->id == $user_id) {
                return true;
            }
        }
    }

    public function getBannerUrlAttribute(){
        if($this->image) {
            return $this->image;
        } else {
            return "http://placehold.it/50/55C1E7/fff&text=". strtoupper($this->name[0]);
        }
    }
}
