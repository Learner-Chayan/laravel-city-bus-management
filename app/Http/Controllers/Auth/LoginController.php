<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{

    use AuthenticatesUsers;


    protected $redirectTo = '/dashboard';


    public function __construct()
    {
        $this->middleware('Setting');
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        $data['page_title'] = "Login";
        return view('auth.login',$data);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                 return redirect('/');

            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id
                ]);

                Auth::login($newUser);

                return redirect()->back();
            }

        } catch (Exception $e) {
            return redirect('auth/google');
        }
    }

}
