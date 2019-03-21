<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods;
use App\Model\Category;
use App\Model\Cart;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    protected static $arrCate=[];
    //
    //分类商品
    public function goodsList($id)
    {
//        $id=input('param.cate_id');
        //echo $id;die;
            if(!empty($id)){
                $this->cateInfo($id);
                $arr=self::$arrCate;
                //print_r($arr);die;
                $goods=new goods;
                $data=$goods->whereIn('cate_id',$arr)->take(5)->get();
                //echo $goods->getLastSql();
                //print_r($data);die;
            }else{
                $data=Goods::take(5)->get();
            }
            $cateInfo=Category::where('pid',0)->get();
        return view('goods/goodsList',['data'=>$data,'cateInfo'=>$cateInfo]);
    }
    //shu
    public function goodsbb(Request $request){
        $cate_id=$request->cate_id;
        //echo $cate_id;die;
        if(!empty($cate_id)){
            $this->cateInfo($cate_id);
            $data=self::$arrCate;
            $arr=Goods::whereIn('cate_id',$data)->get();
            if(!empty($arr)){
                return view('goods/goodsbb',['arr'=>$arr]);
            }else{
                return false;
            }
        }else{
            $arr=Goods::get();
            return view('goods/goodsbb',['arr'=>$arr]);
        }

    }
    //商品详情
    public function goodscontent($id)
    {
        $data=Goods::where('goods_id',$id)->first();
        return view('goods/goodscontent',['data'=>$data]);
    }
    //购物车
    public function goodscart(Request $request)
    {
        $user_tel=(session('user_tel'));
        if(!empty($user_tel)){
            $type=$request->type;
            $goods_id=$request->goods_id;
            $user_id=session('user_id');
            $where=[
                'user_id'=>$user_id,
                'goods_id'=>$goods_id
            ];
            if($type==1){
                $res=Cart::where($where)->first();
                if(!empty($res)){
                    $buy_num=$res['buy_num']+1;
                    $arr=Cart::where($where)->update(['buy_num'=>$buy_num]);
                }else{
                    $arr=Cart::insert(['user_id'=>$user_id,'goods_id'=>$goods_id,'buy_num'=>1]);
                }
                if($arr){
                    echo "1";die;
                }else{
                    echo "0";die;
                }
            }else{
                echo 2;die;
            }

        }else{
            echo 3;die;
        }
        return view('goods/goodscart');
    }
    //获取分类
    public function cateInfo($id){
        $catemodel=new Category;
        $arr=$catemodel->where('pid',$id)->get();
        //print_r($arr);die;
        if(count($arr)!=0){
            foreach ($arr as $v){
                $cateids=$v->cate_id;
                $cateIds=$this->cateInfo($cateids);
                self::$arrCate[]=$cateIds;
            }

        }else{
            return $id;
        }
    }
}
