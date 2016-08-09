<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Socialite;
use Mail;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'dt_create' => date("Y-m-d H:i:s")
        ]);
    }

    public function sendMail(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')).$request->input('email'),
            'dt_create' => date("Y-m-d H:i:s")
        ]);

        $data = array(
            'id' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        );
        $mailto = $request->input('email');

        Mail::send('auth/emails/auth', $data, function ($message) use ($mailto) {

            $message->from('aries2058@gmail.com', 'WWTL');

            $message->to($mailto)->subject('Welcom to wwtl!');

        });
        return view('welcome');
    }

    public function authLoginProcess($id){
        $pwd = User::where('email', $id)->first()->password;
        $pwd = str_replace($id, '', $pwd);
        User::where('email', $id)
            ->update(['password' => $pwd]);

        return view('auth/login');
    }

    public function redirectToAuth($oauth){
        return Socialite::driver($oauth)->redirect();
    }

    public function handleAuthCallback($oauth){
        try{
            $user = Socialite::driver($oauth)->user();
        }catch(Exception $e){
            return redirect('auth/'.$oauth);
        }

        $user = $this->findOrCreateUser($user);
        \Auth::login($user);

        return redirect()->intended('home');
    }

    private function findOrCreateUser($oAuthUser){
        if($user = User::where('email', $oAuthUser->email)->where('auth_key', $oAuthUser->id)->first()){
            return $user;
        }

        return User::create([
            'auth_key'=>$oAuthUser->id,
            'email'=>$oAuthUser->email,
            'name'=>$oAuthUser->name,
            'photo'=>$oAuthUser->avatar,
            'dt_create' => date("Y-m-d H:i:s")
        ]);
    }
}
