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