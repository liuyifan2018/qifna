//请求方法
function requestMethod(url,method,data) {
    let request = {};
    if (data == null){
        request = new Request(url,{
            method:method,
            headers: new Headers({
                'Content-Type': 'application/json'
            })
        });
    }else{
        request = new Request(url,{
            method:method,
            body:JSON.stringify(data),
            headers: new Headers({
                'Content-Type': 'application/json'
            })
        });
    }
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

//请求错误信息
function requestError(error) {
    if (error instanceof Object) {  //layer不支持返回的object错误
        alert(error);
    }else{
        layer.msg(error,{icon:5});
    }
}