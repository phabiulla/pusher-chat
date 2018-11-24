<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    const STATUS_ONLINE  = 'online';
    const STATUS_AWAY    = 'away';
    const STATUS_BUSY    = 'busy';
    const STATUS_OFFLINE = 'offline';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'nick', 'email', 'password', 'status', 'age', 'slogan', 'image' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'password', 'remember_token' ];

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

    // Retorna a ultima mensagem entre dois usuários
    public function getLastMessage($logged){

        return ConversationsIndividual::where("receiver_id", $logged->id)
            ->where("user_id", $this->id)
            ->orWhere(function($q) use ($logged) {
                $q->where("user_id", $logged->id);
                $q->where("receiver_id", $this->id);
            })->orderBy("created_at", "DESC")->first();
    }
}
