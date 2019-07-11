let friend = new Vue({
    el: '#friends',
    data: {
        tabBars: [
            {
                id: 0,
                title: '我的好友',
                active: 'layui-this'
            },
            {
                id: 1,
                title: '搜索好友',
                active: 'layui-this'
            },
            {
                id: 2,
                title: '黑名单',
                active: 'layui-this'
            },
        ],
        friends: [],
        is_show: 2,
        friendInfo: []
    },
    created: function () {
        this.setTab(0);
        this.friendList();
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
        friendList: function () {
            try {
                let request = requestMethod('GET', {});
                fetch('friend', request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.msg != 0) {
                            for (let i = 0; i < res.msg.length; i++) {
                                friend.friends.push(res.msg[i]);
                            }
                            friend.friends = 1;
                        }
                    })
                    .catch(requestError);
            } catch (err) {
                layer.msg(err, {icon: 5});
            }
        },
        searchFriend: function () {
            try {
                let friends = $("#friend").val();
                try {
                    if (friend == "") throw "请输入账号!";
                    if (Number.isInteger(friend)) throw "请输入正确格式!";
                } catch (err) {
                    layer.msg(err, {icon: 5});
                    return false;
                }
                let data = {friend: friends};
                let request = requestMethod('POST', data);
                fetch('searchFriend', request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1) {
                            $("#getFriend").css("display", "block");
                            friend.friendInfo = res.msg;
                        } else {
                            layer.msg(res.msg, {icon: 2});
                        }
                    })
                    .catch(requestError)
            } catch (error) {
                layer.msg(error, {icon: 5});
            }
        },
        addFriend: function (friend) {
            try {
                if (friend == "") throw '参数错误!';
                $.ajax({
                    url:'addFriend',
                    type:'GET',
                    data:{
                        friend: friend
                    },
                    success:function(res){
                        if (res.code == 1){
                            layer.msg(res.msg,{icon:1});
                        } else {
                            layer.msg(res.msg,{icon:5});
                        }
                    },
                    error:function(error){
                        layer.msg(error);
                    }
                });
            }catch (err) {
                layer.msg(err,{icon:5});
            }
        }
    }
});