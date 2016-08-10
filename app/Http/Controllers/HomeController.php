<?php

namespace App\Http\Controllers;
use App\User;
use DB;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if(\Auth::guest()){
            return view('home', ['country' => DB::table('apps_countries')->get(),
                'ratetype' => \App\Ratetype::all()]);
        }
        else if(User::where('seq', $user->seq)->where('birth', '<>', '')->count()==0){
            return view('auth/checkinfo');
        }
        else{
            $user_name = '%'.$user->nick_name.'%';
            return view('home', [
                'country' => DB::table('apps_countries')->get(),
                'ratetype' => \App\Ratetype::all(),
                'rateme'=> DB::table('v_rate_main')
                    ->select('v_rate_main.target_seq', 'v_rate_main.rate_score', 'v_rate_main.name', 'user.photo', 'user.nick_name')
                    ->join('target', 'v_rate_main.target_seq', '=', 'target.seq')
                    ->join('user', 'v_rate_main.user_seq', '=', 'user.seq')
                    ->where('target.first_name', 'like',$user_name )
                    ->orWhere('target.last_name', 'like', $user_name)
                    ->orWhere('target.nick_name', 'like', $user_name)->get(),
                'rated' => DB::table('v_rate_main')
                    ->select('v_rate_main.target_seq', 'v_rate_main.rate_score', 'v_rate_main.name', 'target.photo', 'target.nick_name')
                    ->join('target', 'v_rate_main.target_seq', '=', 'target.seq')
                    ->where('v_rate_main.user_seq', $user->seq)->get()]);
        }
    }
}
