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
        let request = requestMethod('POST',data);
        fetch('login',request)
            .then(requestHandle)
            .then(res =>{
                console.log(res);
                if(res.code == 0){
                    throw res.msg;
                }else{
                    window.location.href = '../Index/index';
                }
            })
            .catch(requestError);
    }catch (err) {
        console.log(err);
        layer.msg(err,{icon:5});
    }
}
