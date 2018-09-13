<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversationsGroup extends Model
{
    protected $table = "conversations_group";
    protected $fillable = ['message', 'user_id', 'group_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
