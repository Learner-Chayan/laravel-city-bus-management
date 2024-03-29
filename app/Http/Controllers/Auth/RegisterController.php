<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->redirectTo = url()->previous();
        $this->middleware('guest');
        $this->middleware('Setting');
    }
    public function showRegistrationForm()
    {

        $data['page_title'] = "Customer Registration";
        return view('auth.register',$data);
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => 'required|numeric|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        //admin = 1 , owner = 2 , driver = 3, checker = 4 , customer = 5 , helper = 6

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'temp_password' => $data['password'],
            'customer_type' => 5,

        ]);
        $role = Role::where('name','customer')->first();
        $user->roles()->attach($role);
        return $user;
    }
}
