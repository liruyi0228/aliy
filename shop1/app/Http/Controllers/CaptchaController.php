<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Captcha;
class CaptchaController extends Controller
{
    public function create()
    {
        $verif=new Captcha();
        $code=$verif->getCode();
        //echo $code;die;
        session(['verifycode'=>$code]);
        return $verif->doimg();
    }
}
