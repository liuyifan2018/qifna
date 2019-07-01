class Fetch {

}

//请求方法
function requestMethod(url,method,data) {
    let request = new Request(url,{
        method:method,
        body:JSON.stringify(data),
        headers: new Headers({
            'Content-Type': 'application/json'
        })
    });
    return request;
}
//请求处理
function requestHandle(res) {
    //请求成功和失败都会进入第一个then
    if (res.ok){
        return res.json();
    }else{
        throw '请求错误!';
    }
}

//请求成功信息
function requestSuccess(res) {
    layer.open({
        title:'提示信息',
        content:res.msg,
        yes:function (index) {
            layer.close(index);
        }
    });
}

//登录专用方法
function requestLogin(res) {
    //请求成功进入的方法 (请求成功不代表程序运行成功!)
    if(res.code == 0){
        throw res.msg;
    }else{
        window.location.href = '../Index/index';
    }
}

//请求错误信息
function requestError(error) {
    layer.msg(error,{icon:5});
}