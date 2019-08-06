<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
    </script>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div>
    <span>您是尊贵的：{{ Session::get('name')}}</span> <a href="out">退出</a></button>
</div>
<span style="font-size: 50px;color:pink;">Laravel增删改查</span>
<br>
<br>
名字:<input type="text" id="name">
<br>
密码:<input type="text" id="password">
<br>
<button onclick="add()">添加数据</button>
<br>
<br>
<table style="text-align: center" border="1" cellspacing="0">
    <th width="50">Id</th><th width="100">Name</th><th width="100">Password</th><th width="100">Option</th>
    <tbody id="ii">

    </tbody>
</table>
<div style="display: none" id="div">
    <input type="text" value="" id="my_id"  hidden>
    名称:<input type="text" value="" id="up_name"  placeholder="在这里修改名称">
    <br>
    密码:<input type="text" value="" id="up_password"  placeholder="在这里修改密码">
    <br>
    <button onclick="up_action()">修改</button>
</div>
</body>
</html>
<script>
    show()
    function show() {
        $.ajax({
            url:"sel",
            dataType:'json',
            success:function (res) {
                tr=''
                for (i=0;i<res.length;i++){
                    tr=tr+"<tr><td>"+res[i].id+"</td><td>"+res[i].user_name+"</td><td>"+res[i].password+"</td><td><span style='color:blue;' onclick='del("+res[i].id+")'>删除</span>&nbsp&nbsp&nbsp<span style='color:blue;' onclick='my_update("+res[i].id+")'>修改</span></td></tr>"
                }
                $("#ii").html(tr)
            }
        })
    }
    function add() {
        var name=$('#name').val()
        var password=$('#password').val()
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url:"add",
            data:{
                name:name,
                password:password,
            },
            type:'post',
            dataType:'json',
            success:function (res) {
                show()
                alert(res.data)
            }
        })
    }
    function del(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url:"del",
            data:{
                id:id,
            },
            type:'post',
            dataType:'json',
            success:function (res) {
                show()
                alert(res.data)
            }
        })
    }
    function my_update(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url:"my_up",
            data:{
                id:id,
            },
            type:"post",
            dataType:"json",
            success:function (res) {
                $('#my_id').val(res[0].id)
                $('#up_name').val(res[0].user_name)
                $('#up_password').val(res[0].password)
                $("#div").css('display','block')
            }
        })
    }
    function up_action() {
        var id=$('#my_id').val()
        var name=$('#up_name').val()
        var password=$('#up_password').val()
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url:"up_action",
            data:{
                id:id,
                name:name,
                password:password,
            },
            type:"post",
            dataType:'json',
            success:function (res) {
                if (res.status=='ok') {
                    alert(res.data)
                    show()
                    $("#div").css('display','none')
                }else{
                    alert(res.data)
                }
            }
        })
    }
</script>
