$(function(){
    $(document).keypress(function (e) {
        if (e.keyCode == 13){
            document.getElementById('but').click();
        }
    })
});
function login(){
    let username = $("#username").val();
    let password = $("#password").val();
    let checkNum = $("#checkNum").val();
    let inPass = $(".orders:checked").val();
    let arr = [username,password];
    for (let i = 0; i < arr.length; i++){
        if(arr[i] == ""){
            layer.msg('必填项不能为空!',{icon:5});
            return false;
        }
    }
    let request = new Request('login',{
        method:'POST',
        body:JSON.stringify({
            checkNum:checkNum,
            inPass : inPass,
            username : username,
            password : password
        }),
        headers: new Headers({
            'Content-Type': 'application/json'
        })
    });
    console.log(username);
    fetch(request)
        .then(res => {
            //请求成功和失败都会进入第一个then
            if (res.ok){
                return res.json();
            }else{
                throw '请求错误!';
            }
        })
        .then(res => {
            //请求成功进入的方法 (请求成功不代表程序运行成功!)
            if(res.code == 0){
                throw res.msg;
            }else{
                window.location.href = '../Index/index';
            }
        })
        .catch(error =>{
            //接收 throw 返回的信息
            layer.msg(error,{icon:5});
        });
    //总结:fetch的第一个then是接到成功或失败的信息,catch是在js里报错原因;
}
