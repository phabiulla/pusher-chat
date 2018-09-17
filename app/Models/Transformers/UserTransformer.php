<?php

namespace App\Models\Transformers;

use App\Models\ConversationsIndividual;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * @var \App\Models\User
     */
    private $user;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function transform(User $user)
    {
        return array(
            'id'            => $user->id,
            'status'        => $user->status,
            'nick'          => $user->nick,
            'slogan'        => $user->slogan,
            'age'           => $user->age,
            'email'         => $user->email,
            'name'          => $user->name,
            'avatar_url'    => $user->avatar_url,
            'created_at'    => $user->created_at,
            'updated_at'    => $user->updated_at,
            'last_message'  => $user->getLastMessage($this->user)
        );
    }
}