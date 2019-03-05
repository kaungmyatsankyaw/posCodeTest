<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->get('name');
        $password = $request->get('password');

        if (Auth::attempt(['name' => $username, 'password' => $password])) {
            return redirect('/admin');
        }
    }

    public function logout(){
//        Auth::logout();
        return redirect('/');
    }

}
