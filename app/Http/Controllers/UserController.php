<?php

namespace App\Http\Controllers;

use App\Events\UserUpdated;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function changeStatus($id)
    {
        $user = User::where("id", $id)->first();
        $user->status = request('status');
        $user->save();

        broadcast(new UserUpdated($user))->toOthers();
        return $user;
    }
}
