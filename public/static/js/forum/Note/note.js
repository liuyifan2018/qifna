$(function(){
    function addNote() {
        let title = $("#title").val();
        let content = $("#content").val();
        let classify = $("#classify").val();
        let money = $("#money").val();
        let is_content = $(".orders:checked").val();
        let arr = [title,content,classify,money,is_content];
        for (let i = 0; i < arr.length; i++){
            if (arr[i] == ""){
                layer.msg('必填项不能为空!',{icon:5});
                return false;
            }
        }
        let request = new Request("Note/addNote",{
            body:JSON.stringify({
                arr:arr
            }),
            method:'POST',
        });
        fetch(request)
            .then((res) => {
                let resData = res.json();
                layer.open({
                    title:'提示信息',
                    content:resData.msg,
                    yes:function (index) {
                        layer.close(index);
                        window.location.reload();
                    }
                });
                setTimeout(function () {
                    window.location.reload();
                },5000);
            })
            .catch((error) => {
                layer.msg(error,{icon: 5});
            })
    }
    
    function editNote(id) {
        if (id == null) layer.msg('参数错误!');
    }
});