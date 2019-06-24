function login(){
    var username = $("#username").val();
    var password = $("#password").val();
    var checkNum = $("#checkNum").val();
    var inPass = $(".orders:checked").val();
    if(username == "" || password == ""){
        layer.msg('必填项不能为空!',{icon:5});
        return false;
    }else{
        $.ajax({
            url:"login",
            type:"POST",
            data:{
                checkNum:checkNum,
                inPass : inPass,
                username : username,
                password : password
            },
            success:function(res){
                if(res.code == 0){
                    layer.msg(res.msg,{icon:5});
                    setTimeout("window.location.reload()",3000);
                    return false;
                }else if(res.code == 1){
                    window.location.href= "../Index/index"
                }
                console.log(res);
            },
            error:function(){
                layer.msg('网络异常!',{icon:2});
            },
            fail:function(err){
                console.log(err);
            }
        })
    }
}
document.onkeydown = function(e){
    if(e.keyCode == 13){
        document.getElementById('btn').click();
    }
}
