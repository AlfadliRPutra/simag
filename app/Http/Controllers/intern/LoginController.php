<?php

namespace App\Http\Controllers\intern;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    //Login untuk user
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()) {
            if (Auth::attempt((['email' => $request->email, 'password' => $request->password]))) {
                return redirect()->route('account.dashboard');
            } else {
                return redirect()->route('account.login')->withErrors(['error' => 'Either email or password is incorrect.']);
            }
        } else {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }
    }
    public function register()
    {
        return view('register');
    }
    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'name' => 'required',
            'password_confirmation' => 'required',
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'customer';
            $user->save();

            return redirect()->route('account.login')->with('success', 'you have registered successfully');
        } else {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
}
