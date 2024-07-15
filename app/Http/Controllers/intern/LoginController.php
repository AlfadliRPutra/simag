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
            'id_pengguna' => 'required',
            'password' => 'required'
        ]);
        if ($validator->passes()) {
            if (Auth::attempt((['id_pengguna' => $request->id_pengguna, 'password' => $request->password]))) {
                return redirect()->route('intern.dashboard');
            } else {
                return redirect()->route('intern.login')->withErrors(['error' => 'Either id_pengguna or password is incorrect.']);
            }
        } else {
            return redirect()->route('intern.login')->withInput()->withErrors($validator);
        }
    }
    public function register()
    {
        return view('register');
    }
    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pengguna' => 'required|unique:users',
            'password' => 'required|confirmed|min:5',
            'name' => 'required',
            'password_confirmation' => 'required',
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->nama = $request->name;
            $user->id_pengguna = $request->id_pengguna;
            $user->password = Hash::make($request->password);
            $user->role = 'intern';
            $user->save();

            return redirect()->route('intern.login')->with('success', 'you have registered successfully');
        } else {
            return redirect()->route('intern.register')->withInput()->withErrors($validator);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('intern.login');
    }
}
