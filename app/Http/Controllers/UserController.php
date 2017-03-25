<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function postCheckinfo(Request $request){
        $user = User::find(\Auth::user()->seq);
        $user->nick_name = $request->input('nick_name');
        $user->photo = $request->input('photo');
        $user->birth = $request->input('birth');
        $user->gender = $request->input('gender');
        $user->job = $request->input('job');
        $user->locale = $request->input('locale');
        $user->dt_update = date("Y-m-d H:i:s");
        $user->save();
    }
    
    public function getMypage(){
        return view('/auth/mypage');
    }

    public function contact(){
        return view('/contact');
    }
}
