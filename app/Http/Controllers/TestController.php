<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Controller;
use Illuminate\Support\facades\Input;
//use Request;

class TestController extends Controller
{
    public function test(){

//        $myfile = fopen("filename.txt", "r") or die("Unable to open file!");
//        echo fread($myfile,filesize("filename.txt"));
        $myfile = fopen("ppp.txt", "r") or die("Unable to open file!");
        echo fread($myfile,filesize("ppp.txt"));
    }
}