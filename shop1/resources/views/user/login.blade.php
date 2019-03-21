@extends('master')
@section('title')
    登陆
    @endsection


@section('content')
    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header">
        <strong id="m-title">登录</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="/" class="m-index-icon"><i class="home-icon"></i></a>
    </div>

    <div class="wrapper">
        <div class="registerCon">
            <div class="binSuccess5">
                <ul>
                    <li class="accAndPwd">
                        <dl>
                            <div class="txtAccount">
                                <input type="hidden" id="_token" value="{{csrf_token()}}">
                                <input id="txtAccount" name="user_tel" type="text" placeholder="请输入您的手机号码/邮箱"><i></i>
                            </div>
                            <cite class="passport_set" style="display: none"></cite>
                        </dl>
                        <dl>
                            <input id="txtPassword" class="pwd" name="user_pwd" type="password" placeholder="密码" value="" maxlength="20" /><b></b>
                        </dl>
                        <dl>
                            <input id="varifycode" type="text" class="code" name="code" placeholder="请输入验证码"  maxlength="8" /><b></b>
                            <img src="{{url('verify/create')}}" style="width:100%;" alt="" id="img">
                        </dl>
                    </li>
                </ul>
                <a id="btnLogin" href="javascript:;" class="orangeBtn loginBtn">登录</a>
            </div>
            <div class="forget">
                <a href="{{url('user/findpwd')}}">忘记密码？</a><b></b>
                <a href="{{url('user/register')}}">新用户注册</a>
            </div>
        </div>
        <div class="oter_operation gray9" style="display: none;">

            <p>登录666潮人购账号后，可在微信进行以下操作：</p>
            1、查看您的潮购记录、获得商品信息、余额等<br />
            2、随时掌握最新晒单、最新揭晓动态信息
        </div>
    </div>

    <div class="footer clearfix" style="display:none;">
        <ul>
            <li class="f_home"><a href="/v44/index.do" ><i></i>潮购</a></li>
            <li class="f_announced"><a href="/v44/lottery/" ><i></i>最新揭晓</a></li>
            <li class="f_single"><a href="/v44/post/index.do" ><i></i>晒单</a></li>
            <li class="f_car"><a id="btnCart" href="/v44/mycart/index.do" ><i></i>购物车</a></li>
            <li class="f_personal"><a href="/v44/member/index.do" ><i></i>我的潮购</a></li>
        </ul>
    </div>
@endsection
@section("my-js")
    <script>

            $(function () {
                $("#img").click(function () {
                    var _this = $(this).attr('src', "{{url('verify/create')}}" + "?" + Math.random());
                })

                    // 手机号失去焦点
                    $('#txtAccount').blur(function () {
                        var reg = /^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[06-8])\d{8}$/;//验证手机正则(输入前7位至11位)
                        var that = $(this);

                        if (that.val() == "" || that.val() == "请输入您的手机号") {
                            layer.msg('请输入您的手机号！');
                            return false;
                        }
                        else if (that.val().length < 11) {
                            layer.msg('您输入的手机号长度有误！');
                            return false;
                        }
                        else if (!reg.test($("#txtAccount").val())) {
                            layer.msg('您输入的手机号不存在!');
                            return false;
                        }
                        else if (that.val().length == 11) {
                            // ajax请求后台数据
                        }
                    })
                    // 密码失去焦点
                    $('.pwd').blur(function () {
                        reg = /^[0-9a-zA-Z]{6,16}$/;
                        var that = $(this);
                        if (that.val() == "" || that.val() == "6-16位数字或字母组成") {
                            layer.msg('请设置您的密码！');
                            return false;
                        } else if (!reg.test($(".pwd").val())) {
                            layer.msg('请输入6-16位数字或字母组成的密码!');
                            return false;
                        }
                    })
                    $(document).on('click','#btnLogin',function(){
                    var user_tel=$('#txtAccount').val();
                    // console.log(user_tel);
                    var user_pwd=$('#txtPassword').val();
                    var code=$('.code').val();
                    var _token=$("#_token").val();
                    if(user_tel==''){
                        layer.msg("手机号码不能为空");
                        return false;
                    }
                    // if(!(/^1[34578]\d{9}$/.test(user_tel))){
                    //     alert("手机号码有误，请重填");exit;
                    // }
                    if(user_pwd==''){
                        layer.msg("密码不能为空");
                        return false;
                    }
                    if(code==''){
                        layer.msg("验证码不能为空");
                        return false;
                    }

                    $.post(
                        "{{url('user/logindo')}}",
                        {_token:_token,user_tel:user_tel,user_pwd:user_pwd,code:code},
                        function(res){
                             // console.log(res);
                            if(res==1){
                                layer.msg("用户不存在");
                                return false;
                            }else if(res==2){
                                layer.msg("验证码错误");
                                return false;
                            }else if(res==4){
                                layer.msg("账号或密码错误!");
                                return false;
                            }else{
                                layer.msg("登陆成功");
                                location.href="{{url('user/userpage')}}";
                            }
                        }
                    )
                })


            })


    </script>
@endsection




