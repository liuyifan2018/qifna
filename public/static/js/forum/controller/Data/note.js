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
            setTabModel(tab);
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

                let data = {id:n_id, type:type};
                let requestAjax = requestAjax('is_show','GET',data);
                layer.confirm('确定要' + name + "吗?", {icon: 5, title: '提示'}, function (index) {
                    if (index) $.ajax(requestAjax);
                })
            } catch (err) {
                layer.msg(err, {icon: 5})
            }
        }
    }
});