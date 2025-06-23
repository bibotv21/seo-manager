<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //

    public function __construct(){

    }

    public function index(){
        if(Auth::check()){
            return redirect()->route('dashboard.index');
        }
        return view('login-page');
    }

    public function login(AuthRequest $request)
    {

        $credentials = [
            'name' => $request->input('user'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard.index');
        }
        
        return redirect()->route('auth.admin')->with('error','Tài khoản hoặc mật khẩu không chính xác');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.admin');
    }
}
