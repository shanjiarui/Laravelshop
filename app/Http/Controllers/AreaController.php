<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Controller;
use Illuminate\Support\facades\Input;
//use Request;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    public function address(Request $request)
    {
        $id=$request->get('id');
        $arr=Db::select("select * from area where parent_id=$id");
        return response()->json(['status'=>'success','data' => $arr]);
    }
    public function add_delivery(Request $request){
        $id=$request->post('id');
        $name=$request->post('name');
        $email=$request->post('email');
        $detailed=$request->post('detailed');
        $phone=$request->post('phone');
        $office=$request->post('office');
        $city=$request->post('city');
//        for ($i=0;$i<count($city);$i++){
//            echo $city[$i];
//        }
        $str=implode(",",$city);
        Db::insert("insert into delivery(u_id,`name`,email,detailed,phone,office,city,`default`) values ($id,'$name','$email','$detailed','$phone','$office','$str',0)");
        return response()->json(['status'=>'success']);
    }
    public function all_detailed(Request $request){
        $id=$request->get('id');
        $arr=Db::select("select * from delivery where u_id=$id order by is_default desc");

        for ($i=0;$i<count($arr);$i++){
            $ayy=[];
            $c_id=$arr[$i]->city;
            $city_id=explode(',',$c_id);
            for ($j=0;$j<count($city_id);$j++){
                $cc_id=$city_id[$j];
                $akk=Db::select("select * from area where area_id=$cc_id");
                $name=$akk[0]->area_name;
                $ayy[]=$name;
            }
            $str=implode('',$ayy);
            $arr[$i]->city=$str;
        }
//        var_dump($arr);
        return response()->json(['status'=>'success','data'=>$arr]);
    }
    public function default_address(Request $request){
        $id=$request->post('id');
        Db::update("update delivery set `is_default`=1 where id=$id");
        Db::update("update delivery set `is_default`=0 where id!=$id");
        return response()->json(['status'=>'success']);
    }
}
