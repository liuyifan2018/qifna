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
    fetch(request)
        .then((res) => {
            return res.json();  //第一次then的时候转JOSN格式
        })
        .then((res) => {
            let resData = res;   //第二次的then的时候就可以得到这个对象了
            if(resData.code == 0){
                layer.msg(resData.msg,{icon:5});
            }else{
                window.location.href = '../Index/index';
            }
        })
        .catch(error =>{
            layer.msg(error + "请稍后重试",{icon:2});
        });
}
document.onkeydown = function(e){
    if(e.keyCode == 13){
        document.getElementById('btn').click();
    }
}
