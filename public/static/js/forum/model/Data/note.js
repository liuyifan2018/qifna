function setTabModel(tab) {
    setTimeout(() => {
        let tabBar = this.tabBars;
        for (let i = 0; i < tabBar.length; i++) {
            tabBar[i].active = "";
        }
        tabBar[tab].active = "layui-this";
    }, 100);
}

function requestAjax(url,type,data) {
   return {
        url:url,
        type:type,
        data:data,
        success:function (res) {
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
        error:function(err){
            layer.msg(err, {icon: 5});
        }
    }
}