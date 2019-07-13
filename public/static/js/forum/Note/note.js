let note = new Vue({
    el: '#note',
    data: {
        commentLists: [],
        report: {
            background: 'rgba(1,1,1,0.5)',
            width: '100vw',
            height: '100vh',
            position: 'fixed',
            zIndex: '999',
            display: 'none'
        },
        formStyle: {
            width: '30%',
            height: '40%',
            background: 'white',
            margin: '200px auto',
            borderRadius: '3px'
        },
        outForm: {
            float: 'right',
            padding: '20px 20px',
            fontSize: '18px',
            fontWeight: '700',
            color: '#5e4505',
            clear: 'both',
            cursor: 'hand'
        },
        textArea: {
            width: '80%',
            height: '40%',
            padding: '10px',
            margin: '30px',
            resize: 'none',
        },
        formSubmit: {
            width: '60px',
            height: '28px',
            background: '#00a4a2',
            border: '1px solid #00a4a2',
            borderRadius: '3px',
            margin: '0px 50px',
            cursor: 'hand'
        },
        noteInfos: []
    },
    created: function () {
        let url = window.location.href;
        if (url != "http://localhost/Qifan/public/index.php/forum/note/addnote.html") {
            this.noteInfo(n_id);
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
                        n_id: n_id,
                    },
                    success: function (res) {
                        if (res.code != 0) {
                            for (let i = 0; i < res.msg.length; i++) {
                                note.commentLists.push(res.msg[i])
                            }
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
        },
        collNote: function (n_id) {
            try {
                is_empty(n_id);
                $.ajax({
                    url: 'collNote',
                    type: 'GET',
                    data: {
                        n_id: n_id
                    },
                    success: function (res) {
                        $("#coll").load(location.href + " #coll");
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1});
                        } else {
                            layer.open({
                                title: '提示信息',
                                content: res.msg,
                                yes: function (index) {
                                    layer.close(index)
                                }
                            })
                        }
                    },
                    error: function (err) {
                        layer.msg(err, {icon: 5})
                    }
                })
            } catch (err) {
                layer.msg(err, {icon: 5});
            }
        },
        addNote: function () {
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
                        $("#note").load(location.href + " #note");
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1});
                        } else {
                            layer.msg(res.msg, {icon: 5});
                        }
                    })
                    .catch(requestError)
            } catch (err) {
                layer.msg(err, {icon: 5});
            }
        },
        report: function (username, noteUser, nid) {
            try {
                is_empty(nid);
                let port = $('#port').val();
                let arr = [port];
                processing(arr);
                let data = {
                    username: username,
                    noteUser: noteUser,
                    n_id: nid,
                    content: port
                };
                let request = requestMethod('POST', data);
                fetch('report', request)
                    .then(requestHandle)
                    .then(res => {
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
                console.log(err);
                layer.msg(err, {icon: 5});
            }
        },
        setReport: function () {
            $("#Report").css('display', 'block');
        },
        getReport: function () {
            $("#Report").css('display', 'none');
        },
        noteInfo: function (id) {
            try {
                is_empty(id);
                $.ajax({
                    url: 'noteInfo',
                    type: 'GET',
                    data: {id: id},
                    success: function (res) {
                        note.noteInfos = res.msg;
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            } catch (error) {
                console.log(error);
                layer.msg(error, {icon: 5});
            }
        },
        editNote: function (id) {
            try {
                is_empty(id);
                let title = $("#title").val();
                let content = $("#content").val();
                let classify = $("#classify").val();
                let is_content = $("#is_content").val();
                let data = {
                    id: id,
                    title: title,
                    content: content,
                    classify: classify,
                    is_content: is_content
                };
                let arr = [title, content, classify, is_content];
                processing(arr);
                let request = requestMethod('POST', data);
                fetch('editNote', request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1});
                        } else {
                            layer.msg(res.msg, {icon: 5});
                        }
                    })
                    .catch(requestError)
            } catch (err) {
                layer.msg(err, {icon: 5});
            }
        },
        delNote: function (id) {
            try {
                layer.confirm('确定要删除吗?此方法不可逆!', {icon: 3, title: '提示'}, function (index) {
                    if (index) {
                        is_empty(id);
                        let data = {id: id};
                        $.ajax({
                            url: 'delNote',
                            type: 'GET',
                            data: data,
                            success: function (res) {
                                if (res.code == 1) {
                                    layer.msg(res.msg, {icon: 1});
                                } else {
                                    layer.msg(res.msg, {icon: 5});
                                }
                            },
                            error: function (err) {
                                layer.msg(err, {icon: 5})
                            }
                        })
                    }
                });
            } catch (err) {
                console.log(err);
                layer.msg(err, {icon: 5});
            }
        }
    }
});