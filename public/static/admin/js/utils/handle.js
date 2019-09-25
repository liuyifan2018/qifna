/**
 * 检测是否有为空的字段
 */
function proString(arr) {
    for (let i = 0; i < arr.length; i++){
        if (arr[i] == "") throw '必填项不能为空!';
    }
}
function is_empty(id) {
    if (id == null || id == "") throw '参数错误!';
}