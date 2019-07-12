function signedModel(data) {
    $.ajax({
        url:'signed',
        type:'GET',
        data:data,
        success:function (res) {
            $("#signed").load(location.href + " #signed");
            layer.open({
                title:'提示信息',
                content:res.msg,
                yes:function(index){
                    window.location.reload();
                    layer.close(index);
                }
            })
        },
        error:function(err){
            layer.msg(err,{icon:5});
        }
    })
}