<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversationsIndividual extends Model
{
    protected $table = "conversations_individual";
    protected $fillable = ['message', 'user_id', 'receiver_id'];

    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function receiver()
    {
        return $this->hasOne(User::class, "id", "receiver_id");
    }
}
