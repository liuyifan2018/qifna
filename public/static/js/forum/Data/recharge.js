let recharge = new Vue({
    el: '#recharge',
    data: {
        tabBars: [
            {
                id: 0,
                title: '开通会员',
                active: 'layui-this'
            },
            {
                id: 1,
                title: '余额会员',
                active: ''
            }
        ],
        money:'1'
    },
    created: function () {
        this.setTab(0);
        this.Money();
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
        /**
         * @return {number}
         */
        Money: function () {
            try {
                let insider = $('#insider').val();
                let arr = [10, 20, 50, 100];
                if (insider == "") {
                    $('#zed').html('请选择!');
                } else {
                    $('#zed').html('应付' + arr[insider] + '元!');
                }
                return arr[insider];
            } catch (err) {
                layer.msg(err, {icon: 5});
            }
        },
        recharge: function () {
            try {
                let money = $("#money").val();
                try {
                    switch (money) {
                        case "":
                            throw "请填写充值余额";
                            break;
                        case money > 9999 :
                            throw "一次充值不能大于9999!";
                            break;
                        case !Number.isInteger(money) :
                            throw "请填写正确格式(数字)!";
                    }
                } catch (err) {
                    layer.msg(err, {icon: 5});
                }
                let data = {money: money};
                let request = requestMethod('POST', data);
                fetch('recharge', request)
                    .then(requestHandle)
                    .then(res => {
                        $("#likeCode").load(location.href + " #likeCode");
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
                    })
                    .catch(requestError);
            } catch (error) {
                layer.msg(error, {icon: 5});
            }
        },
        insider: function () {
            try {
                let insiderMoney = this.Money();
                let insiderName = $("#insider").val();
                if (insiderName == "") layer.msg('请选择会员!', {icon: 5});
                return false;
                let data = {
                    money: insiderMoney,
                    name: insiderName
                };
                let request = requestMethod("POST", data);
                fetch('insider', request)
                    .then(requestHandle)
                    .then(res => {
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
                    })
                    .catch(requestError)
            } catch (err) {
                layer.msg(err, {icon: 5});
            }
        }

    }
});