<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Controller;
use Illuminate\Support\facades\Input;
//use Request;

class BuycarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    public function buycar(Request $request){
        $id=$request->get('id');
        $arr=Db::select("select b_c.id,g.goods_name,b_c.specs_id,b_c.specs_name,b_c.num,g_s.price from buy_car as b_c join goods_specs as g_s on b_c.specs_id=g_s.id join goods as g on g.goods_id=g_s.goods_id where users_id=$id");
        return response()->json(['status'=>'success','data' => $arr]);
    }
    public function add_num(Request $request){
        $id=$request->post('id');
        $arr=Db::select("select * from buy_car where id=$id");
        $num=$arr[0]->num+1;
        Db::update("update buy_car set num=$num where id=$id");
        $ayy=Db::select("select b_c.id,g.goods_name,b_c.specs_id,b_c.specs_name,b_c.num,g_s.price from buy_car as b_c join goods_specs as g_s on b_c.specs_id=g_s.id join goods as g on g.goods_id=g_s.goods_id where b_c.id=$id");
        return response()->json(['status'=>'success','data' => $ayy]);
    }
    public function down_num(Request $request){
        $id=$request->post('id');
        $arr=Db::select("select * from buy_car where id=$id");
        $num=$arr[0]->num-1;
        if ($num<0){
            $num=0;
        }
        Db::update("update buy_car set num=$num where id=$id");
        $ayy=Db::select("select b_c.id,g.goods_name,b_c.specs_id,b_c.specs_name,b_c.num,g_s.price from buy_car as b_c join goods_specs as g_s on b_c.specs_id=g_s.id join goods as g on g.goods_id=g_s.goods_id where b_c.id=$id");
        return response()->json(['status'=>'success','data' => $ayy]);
    }
    public function all_price(Request $request){
        $arr=$request->post('arr');
        if (empty($arr)){
            $price=0;
        }else{
            $price=0;
            for ($i=0;$i<count($arr);$i++){
                $id=$arr[$i];
                $ayy=Db::select("select b_c.id,g.goods_name,b_c.specs_id,b_c.specs_name,b_c.num,g_s.price from buy_car as b_c join goods_specs as g_s on b_c.specs_id=g_s.id join goods as g on g.goods_id=g_s.goods_id where b_c.id=$id");
                $one_price=$ayy[0]->num * $ayy[0]->price;
                $price=$price+$one_price;
            }
        }
        return response()->json(['status'=>'success','data' => $price]);
    }
}