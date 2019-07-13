function signed(username,money){
    try {
        is_empty(username);
        let data = {
            username:username,
            money:money
        };
        signedModel(data);
    }catch (e) {
        console.log(e);
        layer.msg(e,{icon:5});
    }
}
function signedModel(data) {
    $.ajax({
        url:'signed',
        type:'GET',
        data:data,
        success:function (res) {
            if (res.code == 1){
                layer.msg(res.msg,{icon:1});
            } else {
                layer.msg(res.msg,{icon:5});
            }
        },
        error:function(error){
            layer.msg(error,{icon:5});
        }
    })
}