<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(){
        if(Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        return view('administrator.authentication.login');
    }
    public function postLogin(Request $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin')->with('error', 'Login failed');
    }
    public function dashboard(){
        $sidebar = 'dashboard';
        return view('administrator.dashboard.index', compact('sidebar'));
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }
}
