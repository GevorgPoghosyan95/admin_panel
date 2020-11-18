<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('personal');

        } else {
            return redirect()->back()->withErrors('Email or Password incorrect');
        }
    }

    public function personal()
    {
        return view('admin_panel.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
