<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Controller;
use Illuminate\Support\facades\Input;
//use Request;

class GoodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['is_hot','tree','cate_gory','home_goods','goods','price']]);
    }
    public function is_hot(Request $request)
    {
        $arr=Db::select("select * from goods");
        echo json_encode($arr);

    }
    public function tree()
    {
        $arr=Db::select("select * from shop_category");
        $ayy=$this->cate_gory($arr,0,0);
//        var_dump($ayy);
        $js=['code'=>'200','status'=>'success','data'=>$ayy];
        echo json_encode($js);
//        dump($i);
//        echo $i;
//        var_dump($i);
    }
    public function cate_gory($arr,$id,$level)
    {
//        echo $pid.",";
//        $arr=Db::select("select * from shop_category");
        $list =array();
        foreach ($arr as $k=>$v){
            if ($v->parent_id == $id){
                $v->leven=$level;
                $v->son = $this->cate_gory($arr,$v->cate_id,$level+1);
                $list[] = $v;
            }
        }

//            var_dump($list);
        return $list;
//        echo "<pre>";
    }
    public function home_goods()
    {
        $arr=Db::select("select h_g.cate_id,g.goods_name,g.goods_id,h_f.cate_name from goods as g join home_goods as h_g on g.goods_id=h_g.goods_id join home_floor as h_f on h_f.cate_id=h_g.cate_id order by h_f.floor");
//        var_dump($arr);
//        die;
        $array=[];
        foreach ($arr as $key => $value){
            $cate_name=$value->cate_name;
            $cate_id=$value->cate_id;
            $array[$cate_id][$cate_name][]=$value;
        }
//        var_dump($array);
//        var_dump($array[1]) ;die;
        $js=['code'=>'200','status'=>'success','data'=>$array];
        echo json_encode($js);
    }
    public function goods(Request $request){
        $id=$request->get('goods_id');
        $arr=Db::select("select g_s.id,g.goods_id,g_s.goods_attr_id,g_s.price,g_s.stock,g.goods_name from goods as g join goods_specs as g_s on g.goods_id=g_s.goods_id where g_s.goods_id=$id");
//        var_dump($arr);die;
        for ($i=0;$i<count($arr);$i++){
            $new_arr=[];
            $attr_id=$arr[$i]->goods_attr_id;
            $attr=explode('-',$attr_id);
            for ($j=0;$j<count($attr);$j++){
                $attr_iid=$attr[$j];
                $ayy=Db::select("select * from specific_attr where id=$attr_iid");
//                var_dump($ayy);
                $new_arr[]=$ayy[0]->name;
            }
            $new_attr=implode('-',$new_arr);
            $arr[$i]->goods_attr_id=$new_attr;
        }
        $name=Db::select("select goods_name from goods where goods_id=$id");
//        var_dump();
        $js=['code'=>'200','status'=>'success','data'=>$arr,'name'=>$name[0]->goods_name];
        echo json_encode($js);
    }
    public function price(Request $request){
        $id=$request->get('specs_id');
        $arr=DB::select("select price from goods_specs where id=$id");
        $js=['code'=>'200','status'=>'success','price'=>$arr[0]->price];
        echo json_encode($js);
    }
    public function add_buycar(Request $request){
        $specs_id=$request->post('specs_id');
        $num=$request->post('num');
        $response=response()->json(auth()->user());
        $js=json_encode($response);
        $all=json_decode($js,true);
        $id=$all["original"]['id'];
        $apk=Db::select("select * from buy_car where users_id=$id and specs_id=$specs_id");
        if (empty($apk)){
            $arr=Db::select("select * from goods_specs where `id`=$specs_id");
            $attr_id=$arr[0]->goods_attr_id;
            $ayy=explode('-',$attr_id);
            $new_arr=[];
            foreach ($ayy as $key => $value){
                $app=Db::select("select * from specific_attr where id=$value");
                $new_arr[]=$app[0]->name;
            }
            $str=implode('-',$new_arr);
            Db::insert("insert into buy_car(users_id,specs_id,specs_name,num) values ($id,$specs_id,'$str',$num)");
        }else{
            $new_num=$apk[0]->num+$num;
            Db::insert("update buy_car set num=$new_num where users_id=$id and specs_id=$specs_id");
        }
        $js=['code'=>'200','status'=>'success'];
        echo json_encode($js);
    }
}