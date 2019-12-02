//请求方法
function requestMethod(method,data) {
    let request = {};
    if (method == 'POST'){
        request = {
            method:method,
            body:JSON.stringify(data),
            headers: new Headers({
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            })
        };
    }else{
        request = {
            method:method,
            headers: new Headers({
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            })
        };
    }
    return request;
}
//处理GET请求
function requestGet(url,params) {
    if (params) {   //处理有参数的GET
        let paramsArray = [];
        //拼接参数
        Object.keys(params).forEach(key => paramsArray.push(key + '=' + params[key]))
        if (url.search(/\?/) === -1) {
            url += '?' + paramsArray.join('&')
        } else {
            url += '&' + paramsArray.join('&')
        }
    }
    return url;
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
    console.log(error);
    if (error instanceof Object) {  //layer不支持返回的object错误
        alert(error);
    }else{
        layer.msg(error,{icon:5});
    }
}

//带有图片的请求方法
function requestMetImg(method,data) {
    let formData = new FormData();
    let fileField = document.querySelector("input[type='file']");
    formData.append('data',data);
    formData.append('images',fileField.files[0]);
    let request = {};
    request = {
        method:method,
        body:formData
    };
    return request;
}

function safetyHandling(res){
    if (typeof res != "object") {    //防止后台打印返回不是正确格式而找不到res下面的info，不是个对象的处理
        layer.msg('网络异常!',{icon:2});
        return false;
    }
}