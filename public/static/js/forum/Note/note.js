let note = new Vue({
    el: '#note',
    data: {
        commentLists: [],
    },
    created: function () {
        let url = window.location.href;
        if (url != "http://localhost/Qifan/public/index.php/forum/note/addnote.html"){
            this.commentList();
        }
    },
    methods: {
        commentList: function () {
            try {
                $.ajax({
                    url: 'commentLists',
                    type: 'GET',
                    data: {
                        n_id: n_id
                    },
                    success: function (res) {
                        for (let i = 0; i < res.msg.length; i++) {
                            note.commentLists.push(res.msg[i])
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        layer.msg(err, {icon: 5});
                    }
                })
            } catch (err) {
                layer.msg(err);
            }
        },
        content: function (n_id) {
            try {
                is_empty(n_id);
                let content = $("#content").val();
                let arr = [content];
                processing(arr);
                let data = {
                    n_id: n_id,
                    content: content
                };
                let request = requestMethod('POST', data);
                fetch('content', request)
                    .then(requestHandle)
                    .then(res => {
                        $("#content").val('');
                        note.commentLists = [];
                        this.commentList();
                        $("#commentList").load(location.href + " #commentList");
                        layer.open({
                            title: '提示信息',
                            content: res.msg,
                            yes: function (index) {
                                layer.close(index);
                            }
                        })
                    })
                    .catch(requestError);
            } catch (err) {
                layer.msg(err, {icon: 5});
            }
        }
    }
});
function addNote() {
    try {
        let title = $("#title").val();
        let content = $("#content").val();
        let classify = $("#classify").val();
        let money = $("#money").val();
        let is_content = $("#is_content").val();
        let data = {
            title: title,
            content: content,
            classify: classify,
            money: money,
            is_content: is_content
        };
        let arr = [title, content, classify, money, is_content];
        processing(arr);
        let request = requestMethod('POST', data);
        fetch('addNote', request)
            .then(requestHandle)
            .then(res => {
                layer.open({
                    title: '提示信息',
                    content: res.msg,
                    yes: function (index) {
                        layer.close(index);
                    }
                });
            })
            .catch(requestError)
    } catch (err) {
        console.log(err);
        layer.msg(err, {icon: 5});
    }
}
function editNote(id){
    try {
        is_empty(id);
        let title = $("#title").val();
        let content = $("#content").val();
        let classify = $("#classify").val();
        let money = $("#money").val();
        let is_content = $(".orders:checked").val();
        let data = {
            title: title,
            content: content,
            classify: classify,
            money: money,
            is_content: is_content
        };
        let arr = [title, content, classify, money, is_content];
        processing(arr);
        let request = requestMethod('POST', data);
        fetch('editNote', request)
            .then(requestHandle)
            .then(res => {
                layer.open({
                    title: '提示信息',
                    content: res.msg,
                    yes: function (index) {
                        layer.close(index);
                    }
                });
            })
            .catch(requestError)
    } catch (err) {
        console.log(err);
        layer.msg(err, {icon: 5});
    }
}
function delNote(id){
    try {
        is_empty(id);
        $.ajax({
            url:'delNote',
            method:'GET',
        });
        let data = {id: id};
        let request = requestMethod('GET', data);
        fetch('delNote', request)
            .then(requestHandle)
            .then(res => {
                layer.open({
                    title: '提示信息',
                    content: res.msg,
                    yes: function (index) {
                        layer.close(index);
                    }
                });
            })
            .catch(requestError);
    } catch (err) {
        console.log(err);
        layer.msg(err, {icon: 5});
    }
}
function Report(username,noteUser,nid) {
    try {
        is_empty(nid);
        let port = $('#port').val();
        let arr = [port];
        processing(arr);
        let data = {
            username:username,
            noteUser:noteUser,
            n_id:nid,
            content:port
        };
        let request = requestMethod('POST',data);
        fetch('report',request)
            .then(requestHandle)
            .then(res => {
                layer.open({
                    title:'提示信息',
                    content:res.msg,
                    yes:function (index) {
                        layer.close(index);
                    }
                })
            })
            .catch(requestError);
    }catch (err) {
        console.log(err);
        layer.msg(err, {icon : 5});
    }
}
function setReport() {
    document.getElementById('Report').style.display = "block";
}
function getReport() {
    document.getElementById('Report').style.display = "none";
}