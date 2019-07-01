//检测必填参数是否为空
function processing(arr) {
    for (let i = 0; i < arr.length; i++){
        if(arr[i] == ""){
            throw '必填项不能为空!';
        }
    }
}
//检测接收参数是否为空
function is_empty(id) {
    if (id == null || !Number.isInteger(id)) throw('参数错误!');
    if (typeof(id) != "number") throw ('参数错误!');//Number.isInteger是ES6方法,还有很多浏览器没兼容
}