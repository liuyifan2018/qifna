let staff = new Vue({
    el: '#staff',
    data: {},
    created: function () {

    },
    methods: {
        staffAdd: function () {
            let username = $("#username").val();
            let name = $("#name").val();
            let password = $("#password").val();
            let rePass = $("#rePass").val();
            let arr = [username, name, password, rePass];
            let data = {
                username: username,
                name: name,
                password: password,
                rePass: rePass
            };
            try {
                proString(arr);
                let request = requestMethod('POST', data);
                fetch('staffAdd', request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1});
                        } else {
                            layer.msg(res.msg, {icon: 2});
                        }
                    })
                    .catch(requestError)
            } catch (e) {
                layer.msg(e, {icon: 5});
            }
        },
        staffEdit: function (id) {
            let username = $("#username").val();
            let name = $("#name").val();
            let password = $("#password").val();
            let rePass = $("#rePass").val();
            let arr = [username, name, password, rePass];
            let data = {
                id: id,
                username: username,
                name: name,
                password: password,
                rePass: rePass
            };
            try {
                is_empty(id);
                proString(arr);
                let request = requestMethod('POST', data);
                fetch('staffEdit', request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1});
                        } else {
                            layer.msg(res.msg, {icon: 2});
                        }
                    })
                    .catch(requestError)
            } catch (e) {
                layer.msg(e, {icon: 5});
            }
        },
        staffDel: function (id) {
            layer.confirm("确定要删除吗?此方法不可逆!", {title: '提示', icon: 3}, function (index) {
                if (index) {
                    try {
                        is_empty(id);
                        let data = {id: id};
                        let request = requestGet('staffDel', data);
                        fetch(request)
                            .then(requestHandle)
                            .then(res => {
                                if (res.code == 1) {
                                    layer.msg(res.msg, {icon: 1});
                                } else {
                                    layer.msg(res.msg, {icon: 2});
                                }
                            })
                            .catch(requestError)
                    } catch (e) {
                        layer.msg(e, {icon: 5});
                    }
                }
            })
        },
        setStatus: function (id) {
            is_empty(id);
            try {
                let data = {
                    id: id
                };
                let request = requestGet('setStatus', data);
                fetch(request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1});
                        } else {
                            layer.msg(res.msg, {icon: 2});
                        }
                    })
                    .catch(requestError)
            } catch (e) {
                layer.msg(e, {icon: 5});
            }
        }
    }
});