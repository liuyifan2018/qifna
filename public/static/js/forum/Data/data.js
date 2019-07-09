function signed(username,money) {
    try {
        is_empty(username);
        $.ajax({
            url:'signed',
            type:'GET',
            data:{
                username:username,
                money:money
            },
            success:function (res) {
                layer.open({
                    title:'提示信息',
                    content:res.msg,
                    yes:function(index){
                        layer.close(index);
                    }
                })
            },
            error:function(err){
                layer.msg(err,{icon:5});
            }
        })
    }catch (e) {
        console.log(e);
        layer.msg(e,{icon:5});
    }
}