<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\facades\Input;
//use Request;

class ShowController extends Controller
{
    public function show(Request $request)
    {
            return view('show.show');
    }
    public function out(Request $request)
    {
        $request->session()->flush();
        return redirect()->action('LoginController@home');
    }
    public function sel(){
        $arr=Db::select("select * from user");
        echo json_encode($arr);
    }
    public function add(Request $request){
        $name=$request->post('name');
        $password=$request->post('password');
        if ($name==''||$password==''){
            $js=['code'=>'1','status'=>'error','data'=>'用户名或密码不能为空!'];
            echo json_encode($js);
            die;
        }
        $arr=Db::select("select * from user where user_name='$name'");
        if (empty($arr)){
            Db::insert("insert into user(user_name,password) values ('$name','$password')");
            $js=['code'=>'0','status'=>'ok','data'=>'添加成功!'];
        }else{
            $js=['code'=>'1','status'=>'error','data'=>'此用户已存在!'];
        }
        echo json_encode($js);
    }
    public function del(Request $request){
        $id=$request->post('id');
        DB::delete("delete from user where id=$id");
        $js=['code'=>'0','status'=>'ok','data'=>'删除成功!'];
        echo json_encode($js);
    }
    public function my_up(Request $request){
        $id=$request->post('id');
        $arr=Db::select("select * from user where id=$id");
//        $js=['code'=>'0','status'=>'ok','data'=>$arr];
        echo json_encode($arr);
    }
    public function up_action(Request $request){
        $id=$request->post('id');
        $name=$request->post('name');
        $password=$request->post('password');
        $arr=DB::select("select * from user where user_name='$name'");
        if (empty($arr)){
            DB::update("update user set user_name='$name',password='$password'where id = $id");
            $js=['code'=>'0','status'=>'ok','data'=>'修改成功!'];
        }else{
            if ($arr[0]['id']==$id){
                DB::update("update user set user_name='$name',password='$password'where id = $id");
                $js=['code'=>'0','status'=>'ok','data'=>'修改成功!'];
            }else{
                $js=['code'=>'1','status'=>'error','data'=>'此用户已存在!'];
            }
        }
        echo json_encode($js);
    }


}