<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Controller;
use Illuminate\Support\facades\Input;
//use Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    public function show(Request $request)
    {
        $arr=$request->post("id");
        $new_arr=[];
        $all_price=0;
        for ($i=0;$i<count($arr);$i++){
            $id=$arr[$i];
            $ayy=Db::select("select b_c.id,g.goods_name,b_c.specs_id,b_c.specs_name,b_c.num,g_s.price from buy_car as b_c join goods_specs as g_s on b_c.specs_id=g_s.id join goods as g on g.goods_id=g_s.goods_id where b_c.id=$id");
            $price=$ayy[0]->num*$ayy[0]->price;
            $ayy[0]->all_price=$price;
            $all_price+=$price;
            $new_arr[]=$ayy;
        }
        return response()->json(['status'=>'success','data' => $new_arr,'price'=>$all_price]);
    }
    public function go_address(Request $request){
        $id=$request->post('id');
        $arr=Db::select("select * from delivery where is_default=1 and u_id=$id");
        $ayy=[];
        $c_id=$arr[0]->city;
        $city_id=explode(',',$c_id);
        for ($j=0;$j<count($city_id);$j++){
            $cc_id=$city_id[$j];
            $akk=Db::select("select * from area where area_id=$cc_id");
            $name=$akk[0]->area_name;
            $ayy[]=$name;
        }
        $str=implode('',$ayy);
        $arr[0]->city=$str;
        return response()->json(['status'=>'success','data' => $arr]);
    }
    public function add_order(Request $request)
    {
        $arr=$request->post('order');
        $id=$request->post('user_id');
        $price=$request->post('price');
        $specs=$request->post('specs_id');
        $address=$arr['city'].$arr['detailed'];
        $phone=$arr['phone'];
        $time=date('Y-m-d H:i:s',strtotime('now'));
        $date=date('Y-m-d');
        $tt=date('H:i:s');
        $str=str_replace('-','',$date);
        $str1=str_replace(':','',$tt);
        $order_id=$id.$str.$str1;
        Db::insert("insert into my_order(order_id,u_id,address,phone,status,`time`,price) values ('$order_id',$id,'$address','$phone',0,'$time',$price)");
        $akk=Db::select("select * from my_order where order_id='$order_id'");
        $order_idk=$akk[0]->id;
        for ($i=0;$i<count($specs);$i++){
            $bc_id=$specs[$i];
            $amm=Db::select("select b_c.specs_name,b_c.num,g.goods_name,g_s.price from buy_car as b_c join goods_specs as g_s on b_c.specs_id=g_s.id join goods as g on g_s.goods_id=g.goods_id where b_c.id=$bc_id");
            $goods_name=$amm[0]->goods_name;
            $price=$amm[0]->price;
            $num=$amm[0]->num;
            $specs_name=$amm[0]->specs_name;
            Db::insert("insert into in_order(goods_name,specs_name,num,price,order_id) values ('$goods_name','$specs_name','$num','$price','$order_idk')");
            Db::delete("delete from buy_car where id=$bc_id");
        }
        return response()->json(['status'=>'success','data' => '成功加入购物车!','order_id'=>$order_id]);
    }
}