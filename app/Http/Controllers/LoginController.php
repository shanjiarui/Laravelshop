<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Input;
//use Request;

class LoginController extends Controller
{
    public function home()
    {
        return view('login.login');
    }
    public function login_action(Request $request)
    {
        $name = $request->post('name');
        $password = $request->post('password');
        $arr=Db::select("select * from user where user_name='$name' and password='$password'");
        if (empty($arr)){
            $js=['code'=>'0','status'=>'error','data'=>'账号或者密码错误!'];
            echo json_encode($js);
        }else{
            $request->session()->put('id', $arr[0]->id);
            $request->session()->put('name', $name);
            $js=['code'=>'0','status'=>'ok','data'=>'登陆成功!'];
            echo json_encode($js);
        }
    }

}