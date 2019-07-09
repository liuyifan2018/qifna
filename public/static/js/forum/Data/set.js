let set = new Vue({
    el:'#set',
    data:{
        tabBars:[
            {
                id:0,
                title:'我的资料',
                active:'layui-this',
            },
            {
                id:1,
                title:'头像',
                active:'',
            },
            {
                id:2,
                title:'密码',
                active:'',
            },
        ]
    },
    created:function () {
        this.setTab(0);
    },
    methods:{
        setTab :function (tab) {
            setTimeout(()=>{
                let tabBar = this.tabBars;
                for (let i = 0; i < tabBar.length; i++){
                    tabBar[i].active = "";
                }
                tabBar[tab].active = "layui-this";
            },100);
        },
        editUser:function () {
            try {
                let phone = $("#phone").val();
                let email = $("#email").val();
                let name = $("#name").val();
                let city = $("#city").val();
                let auto = $("#auto").val();
                let arr = [phone,email,name,city,auto];
                processing(arr);
                let data = {
                    phone:phone,
                    email:email,
                    city:city,
                    name:name,
                    auto:auto
                };
                let request = requestMethod('POST',data);
                fetch('editUser',request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1){
                            layer.msg(res.msg,{icon:1});
                        }else{
                            layer.open({
                                title:'提示信息',
                                content:res.msg,
                                yes:function(index){
                                    layer.close(index);
                                }
                            })
                        }
                    })
                    .catch(requestError)
            }catch (err) {
                console.log(err);
                layer.msg(err,{icon:5});
            }
        },
        updatePass:function(){
            try {
                let pass = $("#pass").val();
                let repass = $("#repass").val();
                let arr = [pass,repass];
                let data = {
                    pass:pass,
                    repass:repass
                };
                processing(arr);
                let request = requestMethod("POST",data);
                fetch('updatePass',request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1){
                            layer.msg(res.msg,{icon:1});
                        }else{
                            layer.open({
                                title: '提示信息',
                                content: res.msg,
                                yes: function (index) {
                                    layer.close(index);
                                }
                            })
                        }
                    })
                    .catch(requestError)
            }catch (err) {
                layer.msg(err,{icon:5});
            }
        }
    }
});