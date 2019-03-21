<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    //我的
    public function userpage()
    {
        return view('user/userpage');
    }
    //手机号唯一性
    public function usertel(Request $request)
    {
        $user_tel=$request->user_tel;
        $arr=User::where('user_tel',$user_tel)->count();
        if($arr){
            echo 1;
        }else{
            echo 0;
        }
    }

    //登陆
    public function login()
    {
        return view('user/login');
    }
    //登陆执行
    public function Logindo(Request $request)
    {
        $user_tel=$request->user_tel;
        $user_pwd=$request->user_pwd;
        //echo $user_pwd;die;
        $code=$request->code;
        $verifycode=session('verifycode');
        $arr=user::where('user_tel','=',$user_tel)->first();
        if(empty($arr)){
            //用户不存在
            echo 1;exit;
        }
        if($user_pwd!=$arr['user_pwd']){
            session(['user_id'=>$arr['user_id']]);
            echo 4;exit;
        }
        if($code!=$verifycode){
            echo 2;exit;
        }else{
            echo 3;
            session(['user_id'=>$arr['user_id'],'user_tel'=>$user_tel]);
        }
    }

    //注册
    public function register(Request $request)
    {
        $user_tel=$request->user_tel;
//        echo $user_tel;die;
        //echo $user_tel;die;
        if(empty($user_tel)){

        }else{
            $code=rand(1111,9999);
            session(['user_tel'=>$user_tel,'code'=>$code]);
            $this->sendMobile($code,$user_tel);
            die;
//            echo $res;die;
            if($res==0){
                echo 0;
            }else{
                echo 1;
            }
        }
        return view('user/register');

    }
    //注册执行
    public function registerAdd(Request $request)
    {
        $user_tel=$request->user_tel;
        $user_pwd=$request->user_pwd;
        //echo $user_pwd;die;
        $code=$request->code;
        $tel=session('user_tel');
        $codes=session('code');
        if($user_tel!=$tel){
            echo 3;die;
        }
        if($code!=$codes){
            echo 4;die;
        }
//        $validate=$request->validate([
//           'user_tel'=>"required|unique:user|regex:/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[06-8])\d{8}$/",
//           'user_pwd'=>"required|regex:/^[0-9a-zA-Z]{6,16}$/",
//        ],[
//            'user_tel.required'   =>"请输入手机号",
//            'user_tel.unique'     =>'该手机号已存在!',
//            'user_tel.regex'      =>'由数字组成11位',
//            'user_pwd.required'   =>"请输入密码!",
//            'user_pwd.regex'      =>'密码由数字 字母组成 6-16位'
//        ]);
        $res=[
            'user_tel'=>$user_tel,
            'user_pwd'=>$user_pwd
        ];
        $arr=User::insert($res);
        if($arr){
            echo 1;
        }else{
            echo 2;die;
        }
    }
    //发送信息
    private function sendMobile($code,$mobile)
    {
        $host = env("MOBILE_HOST");
        $path = env("MOBILE_PATH");
        $method = "POST";
        $appcode = env("MOBILE_APPCODE");
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "content=【创信】你的验证码是：".$code."，3分钟内有效！&mobile=".$mobile;
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        return curl_exec($curl);
    }
    
}
