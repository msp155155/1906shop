<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\LoginModel;
class LoginController extends Controller
{
    public function login()
    {
        return view('login.index');
    }
    public function loginDo(Request $request)
    {
        $user = $request->input('user');
        $pwd = $request->input('pwd');
        $name = LoginModel::where('user_name',$user)->first();
        $email = LoginModel::where('user_email',$user)->first();
        $phone = LoginModel::where('user_phone',$user)->first();
        if ($name || $email || $phone){
            if ($name->user_password = $pwd || $email->user_password = $pwd || $phone->user_password = $pwd){
                return 1;
            }
        }else{
            return 404;
        }
    }
}
