<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Transformers\UserTransformer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '<>', auth()->user()->id)->get();
        $transformer = new UserTransformer(Auth::user());
        $userTransformer = new Collection();

        foreach ($users as $u){
            $userTransformer->push($transformer->transform($u));
        }

        $user = auth()->user();

        return view('home', ['users' => $userTransformer, 'user' => $user]);
    }
}
