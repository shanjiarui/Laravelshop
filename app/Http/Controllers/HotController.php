<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Controller;
use Illuminate\Support\facades\Input;
//use Request;

class HotController extends Controller
{
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

}