@extends('master')
@section('title',"注册")
@section('content')
    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header">
        <strong id="m-title">注册</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
    </div>
    <div class="wrapper">
        <input name="hidForward" type="hidden" id="hidForward" />

        <div class="registerCon">
            <input type="hidden" name="" value="{{csrf_token()}}" id="_token">
            <ul>
                <li class="accAndPwd">
                    <dl>
                        <s class="phone"></s><input id="userMobile" class="user_tel" name="user_tel" maxlength="11" type="text" placeholder="请输入您的手机号码" value="" />
                        <span class="clear">x</span>
                    </dl>
                    <dl>
                        <s class="password"></s>
                        <input class="pwd" maxlength="11" id="pwd" type="password" placeholder="6-16位数字、字母组成" />

                        <span class="mr clear">x</span>
                        <s class="eyeclose"></s>
                    </dl>
                    <dl>
                        <s class="password"></s>
                        <input class="conpwd" maxlength="11" type="text" placeholder="请确认密码" value="" />
                        <input class="conpwd" maxlength="11" type="password" placeholder="请确认密码" value="" style="display: none" />
                        <span class="mr clear">x</span>
                        <s class="eyeclose"></s>
                    </dl>
                    <dl>
                        <dl>
                            <s class="phone"></s><input id="code" maxlength="11" type="text" placeholder="请输入验证码" style="width:70%;" />
                            <button class="orangeBtn loginBtn" style="width:30%; float:right; background-color:red;" id="but">获取</button>
                            <span class="clear">x</span>

                        </dl>
                        </dl>
                    <dl class="a-set">
                        <i class="gou"></i><p>我已阅读并同意《666潮人购购物协议》</p>
                    </dl>

                </li>
                <li><a id="btnNext" href="javascript:;" class="orangeBtn loginBtn">注册</a></li>
            </ul>
        </div>


        <div class="footer clearfix" style="display:none;">
            <ul>
                <li class="f_home"><a href="/v44/index.do" ><i></i>云购</a></li>
                <li class="f_announced"><a href="/v44/lottery/" ><i></i>最新揭晓</a></li>
                <li class="f_single"><a href="/v44/post/index.do" ><i></i>晒单</a></li>
                <li class="f_car"><a id="btnCart" href="/v44/mycart/index.do" ><i></i>购物车</a></li>
                <li class="f_personal"><a href="/v44/member/index.do" ><i></i>我的云购</a></li>
            </ul>
        </div>
        <div class="layui-layer-move"></div>



    </div>
@endsection
@section("my-js")
    <script>
        $('.registerCon input').bind('keydown',function(){
            var that = $(this);
            if(that.val().trim()!=""){

                that.siblings('span.clear').show();
                that.siblings('span.clear').click(function(){
                    console.log($(this));

                    that.parents('dl').find('input:visible').val("");
                    $(this).hide();
                })

            }else{
                that.siblings('span.clear').hide();
            }

        })
        function show(){
            if($('.registerCon input').attr('type')=='password'){
                $(this).prev().prev().val($("#passwd").val());
            }
        }
        function hide(){
            if($('.registerCon input').attr('type')=='text'){
                $(this).prev().prev().val($("#passwd").val());
            }
        }
        $('.registerCon s').bind({click:function(){
                if($(this).hasClass('eye')){
                    $(this).removeClass('eye').addClass('eyeclose');

                    $(this).prev().prev().prev().val($(this).prev().prev().val());
                    $(this).prev().prev().prev().show();
                    $(this).prev().prev().hide();


                }else{
                    console.log($(this  ));
                    $(this).removeClass('eyeclose').addClass('eye');
                    $(this).prev().prev().val($(this).prev().prev().prev().val());
                    $(this).prev().prev().show();
                    $(this).prev().prev().prev().hide();

                }
            }
        })

        function registertel(){
            // 手机号失去焦点
            $('#userMobile').blur(function(){
                reg=/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[06-8])\d{8}$/;//验证手机正则(输入前7位至11位)
                var that = $(this);

                if( that.val()==""|| that.val()=="请输入您的手机号")
                {
                    layer.msg('请输入您的手机号！');
                }
                else if(that.val().length<11)
                {
                    layer.msg('您输入的手机号长度有误！');
                }
                else if(!reg.test($("#userMobile").val()))
                {
                    layer.msg('您输入的手机号不存在!');
                }
                else if(that.val().length == 11){
                    // ajax请求后台数据
                    var user_tel=that.val();
                    var _token=$("#_token").val();
                    //console.log(token);
                    $.post(
                        "{{url('user/usertel')}}",
                        {_token:_token,user_tel:user_tel},
                        function(res){
                            if(res==1){
                                layer.msg("该手机号已被注册!");
                            }
                        }
                    )
                }
            })
            // 密码失去焦点
            $('.pwd').blur(function(){
                reg=/^[0-9a-zA-Z]{6,16}$/;
                var that = $(this);
                if( that.val()==""|| that.val()=="6-16位数字或字母组成")
                {
                    layer.msg('请设置您的密码！');
                }else if(!reg.test($(".pwd").val())){
                    layer.msg('请输入6-16位数字或字母组成的密码!');
                }
            })

            // 重复输入密码失去焦点时
            $('.conpwd').blur(function(){
                var that = $(this);
                var pwd1 = $('.pwd').val();
                var pwd2 = that.val();
                if(pwd1!=pwd2){
                    layer.msg('您俩次输入的密码不一致哦！');
                }
            })
            //点击获取
            $("#but").click(function(){
                var user_tel=$(".user_tel").val();
                var _token=$("#_token").val();
                $.post(
                    "{{url('user/register')}}",
                    {_token:_token,user_tel: user_tel},
                    function(res){
                        if(res==1){
                            layer.msg("发送成功!");
                        }else{
                            layer.msg("发送失败!");
                        }
                    }
                )
            })

        }
        registertel();
        // 购物协议
        $('dl.a-set i').click(function(){
            var that= $(this);
            if(that.hasClass('gou')){
                that.removeClass('gou').addClass('none');
                $('#btnNext').css('background','#ddd');

            }else{
                that.removeClass('none').addClass('gou');
                $('#btnNext').css('background','#f22f2f');
            }

        })
        // 点击注册
        $('#btnNext').click(function(){
            if($('#userMobile').val()==''){
                layer.msg('请输入您的手机号！');
            }else if($('.pwd').val()==''){
                layer.msg('请输入您的密码!');
            }else if($('.conpwd').val()==''){
                layer.msg('请您再次输入密码！');
            }
            var user_tel=$('#userMobile').val();
            var user_pwd=$('#pwd').val();
            var code=$("#code").val();
            var _token=$("#_token").val();
            $.post(
                "{{url('user/registerAdd')}}",
                {_token:_token,user_tel:user_tel,user_pwd:user_pwd,code:code},
                function(res){
                    if(res==3){
                        layer.msg("手机号有误,请查看!");
                    }else if(res==4){
                        layer.msg("验证码错误!");
                    }else if(res==1){
                        layer.msg("注册成功");
                        location.href="{{url('user/login')}}";
                    }else if(res==2){
                        layer.msg("注册失败!");
                    }
                }
            )
        })


    </script>
@endsection



