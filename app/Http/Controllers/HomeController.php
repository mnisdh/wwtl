<?php

namespace App\Http\Controllers;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;

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
        if(\Auth::guest()){
            return view('home');
        }
        else{
            if(User::where('user_seq', \Auth::user()->user_seq)->where('photo','<>', '')->count()==0){
                return view('auth/checkinfo');
            }
            else{
                return view('home');
            }
        }
    }
}
