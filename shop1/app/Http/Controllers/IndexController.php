<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Category;

class IndexController extends Controller
{
    //首页
    public function index()
    {
        $data=Goods::where('is_up',1)->get();
        $cateInfo=Category::get();
        //print_r($cateInfo);die;
        //$goods_num=[];
//        foreach($cateInfo as $k=>$v){
//            foreach ($data as $key=>$val){
//                if($val->cate_id==$v->cate_id){
//                    $data[$key]['goods_num']=$val->goods_num-1000*0.1;
//                }
//            }
//        }
        $cateInfo=$this->cateInfo($cateInfo);
        //print_r($cateInfo);
        return view("index",['data'=>$data,'cateInfo'=>$cateInfo]);
    }

    //获取分类
    public function cateInfo($cateInfo,$pid=0){
        static $arr=[];
        foreach($cateInfo as $k=>$v){
            if($v['pid']==$pid){
                $arr[]=$v;
            }
        }
        return $arr;
    }
}
