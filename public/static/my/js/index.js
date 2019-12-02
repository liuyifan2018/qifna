let Qifan = new Vue({
    el: '#qifan',
    data: {
        tabBar: [
            {
                id: 0,
                title: '首页',
                active: false
            },
            {
                id: 1,
                title: '帖子',
                active: false
            },
            {
                id: 2,
                title: '日记',
                active: false
            },
            {
                id: 3,
                title: '相册',
                active: false
            },
            {
                id: 4,
                title: '留言',
                active: false
            },
        ],
        lists: [],
        userInfo: []
    },

    created: function () {
        this.CURD = Object.create(CURD);
        this.getData(0);
    },

    methods: {
        //获取数据
        getData: function (tab) {
            try {
                this.activeUpdate(tab);
                let data = {
                    tab: tab
                };
                let request = requestGet('getData', data);
                fetch(request)
                    .then(requestHandle)
                    .then(res => {
                        if (typeof res != 'object') {
                            layer.msg('信息获取失败!', {icon: 5});
                            return;
                        }
                        Qifan.lists = res.data
                    })
                    .catch(err => {
                        requestError(err);
                    })
            } catch (e) {
                console.log(e);
                layer.msg(e, {icon: 2});
            }
        },
        //修改TabBar样式
        activeUpdate: function (tab) {
            for (let i = 0; i < this.tabBar; i++) {
                this.tabBar[i].active = false;
            }
            this.tabBar[tab].active = true;
        }
    }
});