let message = new Vue({
    el:'#message',
    data:{
        tabBars:[
            {
                id:0,
                title:'好友验证',
                active:'layui-this'
            },
            {
                id:1,
                title:'会员消息',
                active:''
            },
            {
                id:2,
                title:'帖子消息',
                active:''
            },
            {
                id:3,
                title:'回复信息',
                active:''
            }
        ],
        csg:[],
        rsg:[],
        fsg:[]
    },
    created:function () {
        this.setTab(0);
        this.messageList();
    },
    methods:{
        setTab:function(tab){
            setTimeout(() => {
                let tabBar = this.tabBars;
                for (let i = 0; i < tabBar.length; i++) {
                    tabBar[i].active = "";
                }
                tabBar[tab].active = "layui-this";
            }, 100);
        },
        messageList:function(){
            try {
                let request = requestMethod('GET',{});
                fetch('messageList',request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.msg.csg != []){
                            for (let i = 0; i < res.msg.csg.length; i++){
                                message.csg.push(res.msg.csg[i]);
                            }
                        }
                        if (res.msg.fsg != []){
                            for (let i = 0; i < res.msg.fsg.length; i++){
                                message.fsg.push(res.msg.fsg[i]);
                            }
                        }
                        if (res.msg.rsg != []){
                            for (let i = 0; i < res.msg.rsg.length; i++){
                                message.rsg.push(res.msg.rsg[i]);
                            }
                        }
                    })
                    .catch(requestError)
            }catch (err) {
                
            }
        },
        AgreeFriend:function(type,username){
            try {
                is_empty(username);
                let name;
                switch (type) {
                    case 1: name = '同意';break;
                    case 2: name = '拒绝';break;
                    case 3: name = '忽略';break;
                }
                let data = {
                    type:type,
                    username:username
                };
                layer.confirm('确定要' + name + '吗?此方法不可逆!',{icon:3,title:'提示'},function(index){
                    if (index){
                        $.ajax({
                            url:'AgreeFriend',
                            type:'GET',
                            data:data,
                            success:function(res){
                                $("#messageInfo").load(location.href + " #messageInfo");
                                if (res.code == 1){
                                    layer.msg(res.msg,{icon:1});
                                }else{
                                    layer.msg(res.msg,{icon:2});
                                }
                            },
                            error:function (error) {
                                console.log(error);
                                layer.msg(error,{icon:5});
                            }
                        });
                    }
                })
            }catch (err) {
                layer.msg(err,{icon:5});
            }
        }
    }
});