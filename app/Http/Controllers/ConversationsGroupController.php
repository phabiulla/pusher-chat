<?php

namespace App\Http\Controllers;

use App\Models\ConversationsGroup;
use App\Events\NewMessageGroup;
use Illuminate\Http\Request;

class ConversationsGroupController extends Controller
{
    public function show($id)
    {
        $conversations = ConversationsGroup::where("group_id", $id)->orderBy("created_at", "DESC")->with(array("user"))->limit(3)->get();

        return $conversations;
    }

    public function store()
    {
        $conversation = ConversationsGroup::create([
            'message' => request('message'),
            'group_id' => request('group_id'),
            'user_id' => auth()->user()->id,
        ]);

        broadcast(new NewMessageGroup($conversation))->toOthers();

        return $conversation->load('user');
    }
}
