<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Login
    public function index()
    {
        if (Session::has('loginId')) {
            return redirect()->route('std.myWelcomeView');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $authLogin = User::where('email', $request->email)->first();

        if ($authLogin && Hash::check($request->password, $authLogin->password)) {
            Auth::login($authLogin);
            Session::put('loginId', $authLogin->id);
            return redirect()->route('std.myWelcomeView')->with('success', 'Login successful');
        } else {
            return back()->with('fail', 'Email or password is incorrect');
        }
    }

    // Register
    public function indexRegister()
    {
        if (Session::has('loginId')) {
            return redirect()->route('std.myWelcomeView');
        }
        return view('auth.register');
    }

    public function userRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['password'] = bcrypt($request->password);
        User::create($input);

        return redirect()->route('auth.index')->with('success', 'Registration successful');
    }

    // Logout
    public function logout()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');
            return redirect()->route('auth.index')->with('success', 'Logout successfully');
        } else {
            return redirect()->route('auth.index')->with('error', 'You are not logged in');
        }
    }
}