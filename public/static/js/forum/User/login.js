$(function(){
    $(document).keypress(function (e) {
        if (e.keyCode == 13){
            document.getElementById('but').click();
        }
    })
});

function login(){
    try {
        let username = $("#username").val();
        let password = $("#password").val();
        let checkNum = $("#checkNum").val();
        let inPass = $(".orders:checked").val();
        let data = {
            checkNum:checkNum,
            inPass : inPass,
            username : username,
            password : password
        };
        let arr = [username,password];
        processing(arr);
        let request = requestMethod('login','POST',data);
        fetch(request)
            .then(requestHandle)
            .then(res =>{
                //请求成功进入的方法 (请求成功不代表程序运行成功!)
                if(res.code == 0){
                    throw res.msg;
                }else{
                    window.location.href = '../Index/index';
                }
            })
            .catch(requestError);//接收 throw 返回的信息
        //总结:fetch的第一个then是接到成功或失败的信息,catch是在js里报错原因;
    }catch (err) {
        console.log(err);
        layer.msg(err,{icon:5});
    }
}
