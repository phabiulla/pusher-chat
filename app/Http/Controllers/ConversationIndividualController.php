<?php

namespace App\Http\Controllers;

use App\Events\NewMessageIndividual;
use App\Models\ConversationsIndividual;
use Illuminate\Http\Request;

class ConversationIndividualController extends Controller
{
    public function show($id)
    {
        $conversations = ConversationsIndividual::with(array("user"))
            ->where("receiver_id", $id)
            ->where("user_id", $this->user->id)
            ->orWhere(function($q) use ($id) {
                $q->where("user_id", $id);
                $q->where("receiver_id", $this->user->id);
            })->orderBy("created_at", "DESC")->limit(5)->get();

        return array_reverse($conversations->toArray());
    }

    public function store()
    {
        $conversation = ConversationsIndividual::create([
            'message' => request('message'),
            'receiver_id' => request('receiver_id'),
            'user_id' => auth()->user()->id,
        ]);

        broadcast(new NewMessageIndividual($conversation))->toOthers();

        return $conversation->load('user');
    }
}
