function addNote() {
    try {
        let title = $("#title").val();
        let content = $("#content").val();
        let classify = $("#classify").val();
        let money = $("#money").val();
        let is_content = $("#is_content").val();
        let data = {
            title:title,
            content:content,
            classify:classify,
            money:money,
            is_content:is_content
        };
        let arr = [title,content,classify,money,is_content];
        processing(arr);
        let request = requestMethod('POST',data);
        fetch('addNote',request)
            .then(requestHandle)
            .then(res => {
                layer.open({
                    title:'提示信息',
                    content:res.msg,
                    yes:function (index) {
                        layer.close(index);
                    }
                });
            })
            .catch(requestError)
    }catch (err) {
        console.log(err);
        layer.msg(err,{icon:5});
    }
}
function editNote(id) {
    try {
        is_empty(id);
        let title = $("#title").val();
        let content = $("#content").val();
        let classify = $("#classify").val();
        let money = $("#money").val();
        let is_content = $(".orders:checked").val();
        let data = {
            title:title,
            content:content,
            classify:classify,
            money:money,
            is_content:is_content
        };
        let arr = [title,content,classify,money,is_content];
        processing(arr);
        let request = requestMethod('POST',data);
        fetch('editNote',request)
            .then(requestHandle)
            .then(res => {
                layer.open({
                    title:'提示信息',
                    content:res.msg,
                    yes:function (index) {
                        layer.close(index);
                    }
                });
            })
            .catch(requestError)
    }catch (err) {
        console.log(err);
        layer.msg(err,{icon:5});
    }
}

function delNote(id) {
    try {
        is_empty(id);
        let data = {id:id};
        let request = requestMethod('GET',data);
        fetch('delNote',request)
            .then(requestHandle)
            .then(res => {
                layer.open({
                    title:'提示信息',
                    content:res.msg,
                    yes:function (index) {
                        layer.close(index);
                    }
                });
            })
            .catch(requestError);
    }catch (err) {
        console.log(err);
        layer.msg(err,{icon:5});
    }
}