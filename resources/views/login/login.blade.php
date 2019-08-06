<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href={{ URL::asset('lcss/normalize.css') }}"" />
    <link rel="stylesheet" type="text/css" href={{ URL::asset('lcss/demo.css') }}"" />
    <link rel="stylesheet" href="{{ URL::asset('ljs/vendor/jgrowl/css/jquery.jgrowl.min.css') }}">
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('lcss/component.css') }}" />
    <!--[if IE]>
    <script src="ljs/html5.js"></script>
    <![endif]-->
    <style>
        input::-webkit-input-placeholder{
            color:rgba(0, 0, 0, 0.726);
        }
        input::-moz-placeholder{   /* Mozilla Firefox 19+ */
            color:rgba(0, 0, 0, 0.726);
        }
        input:-moz-placeholder{    /* Mozilla Firefox 4 to 18 */
            color:rgba(0, 0, 0, 0.726);
        }
        input:-ms-input-placeholder{  /* Internet Explorer 10-11 */
            color:rgba(0, 0, 0, 0.726);
        }
    </style>
</head>
<body>
<div class="container demo-1">
    <div class="content">
        <div id="large-header" class="large-header">
            <canvas id="demo-canvas"></canvas>
            <div class="logo_box">
                <h3>登陆</h3>
{{--                <form action="http://myshop.shanjiarui.com/index.php/admin/login/login.html" name="f" method="post">--}}
                    <div class="input_outer">
                        <span class="u_user"></span>
                        <input id="name" class="text" style="color: #000000 !important" type="text" placeholder="请输入账户">
                    </div>
                    <div class="input_outer">
                        <span class="us_uer"></span>
                        <input id="password"  class="text" style="color: #000000 !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">

                    </div>
                <span id="status"></span>
                    <div id="LOGIN" class="mb2"><input type="button" value="登陆" class="act-but submit" style="color: #FFFFFF" onclick="login_action()"></div>
{{--                </form>--}}
            </div>
        </div>
    </div>
</div><!-- /container -->

<script src="{{ URL::asset('ljs/TweenLite.min.js') }}"></script>
<script src="{{ URL::asset('ljs/EasePack.min.js') }}"></script>
<script src="{{ URL::asset('ljs/jquery.js') }}"></script>
<script src="{{ URL::asset('ljs/rAF.js') }}"></script>
<script src="{{ URL::asset('ljs/demo-1.js') }}"></script>
{{--<script src="ljs/vendor/jgrowl/jquery.jgrowl.min.js"></script>--}}
{{--<script src="ljs/Longin.js"></script>--}}
<script>
    function login_action(){
        var name=$('#name').val()
        var password=$('#password').val()
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url:"login_action",
            data:{
                name:name,
                password:password,
            },
            type:'post',
            dataType:'json',
            success:function (res) {
                if (res.status=="error"){
                    $("#status").css('color','red')
                    $("#status").html(res.data)
                }else{
                    $("#status").css('color','green')
                    $("#status").html(res.data)
                    location.href="show"
                }
            }
        })
    }

</script>
</body>
</html>