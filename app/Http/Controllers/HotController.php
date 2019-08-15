<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Controller;
use Illuminate\Support\facades\Input;
//use Request;

class HotController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login','is_hot','tree','cate_gory','home_goods','goods','price']]);
//    }
    public function is_hot(Request $request)
    {
        $arr=Db::select("select * from goods");
        echo json_encode($arr);

    }

}