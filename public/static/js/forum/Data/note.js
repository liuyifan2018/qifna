let note = new Vue({
    el: '#note',
    data: {
        tabBars: [
            {
                id: 0,
                title: '我的贴子',
                active: 'layui-this'
            },
            {
                id: 1,
                title: '收藏帖子',
                active: ''
            }
        ]
    },
    created: function () {
        this.setTab(0);
    },
    methods: {
        setTab: function (tab) {
            setTimeout(() => {
                let tabBar = this.tabBars;
                for (let i = 0; i < tabBar.length; i++) {
                    tabBar[i].active = "";
                }
                tabBar[tab].active = "layui-this";
            }, 100);
        },
        is_show: function (n_id, type) {
            try {
                is_empty(n_id);
                let name;
                switch (type) {
                    case 1:name = "上架";break;
                    case 2:name = "下架";break;
                    default:throw "网络异常,请重试!";
                }
                layer.confirm('确定要' + name + "吗?", {icon: 5, title: '提示'}, function (index) {
                    if (index) {
                        $.ajax({
                            url: 'is_show',
                            type: 'GET',
                            data: {
                                id: n_id,
                                type: type
                            },
                            success: function (res) {
                                if (res.code == 1) {
                                    layer.msg(res.msg, {icon: 1});
                                } else {
                                    layer.open({
                                        title: '提示信息',
                                        content: res.msg,
                                        yes: function (index) {
                                            layer.close(index);
                                        }
                                    })
                                }
                            },
                            error: function (err) {
                                layer.msg(err, {icon: 5});
                            }
                        });
                    } else {
                        layer.msg('已取消');
                    }
                })
            } catch (err) {
                console.log(err);
                layer.msg(err, {icon: 5})
            }
        },
        noteUrl:function(id){
            is_empty(id);
            window.location.href = "http://localhost/Qifan/public/index.php/forum/note/editNote.html?id=" + id;
        },
    }
});