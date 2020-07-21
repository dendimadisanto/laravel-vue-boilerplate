<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserLogin;
use Illuminate\Support\Str;

class userController extends Controller
{
    function doLogin(Request $request){
        try{
            $username = $request->username;
            $password = md5($request->password);
            
            $res = UserLogin::where('username','=',$username)->where('password','=',$password)->first();
            if($res){
                $token = Str::random(60);
                $res->token = $token;
                $res->save();
                $out = $this->res_successMsg('Login Berhasil', $res);
            }

            else{
                $out = $this->res_errorMsg('Something Wrong');
            }
            
            return $out;
        }
        catch(Exception $error){
            return $this->res_errorMsg('Something Wrong', $error);
        }
    }
}
