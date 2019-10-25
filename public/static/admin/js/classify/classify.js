let classify = new Vue({
    el: '#classify',
    data: {},
    created: function () {

    },
    methods: {
        classifyAdd: function () {
            let classifyName = $("#classifyName").val();
            let sort = $("#sort").val();
            let arr = [classifyName, sort];
            let data = {
                title: classifyName,
                sort: sort
            };
            let request = requestMethod('POST', data);
            try {
                proString(arr);
                fetch('classifyAdd', request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1});
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        } else {
                            layer.msg(res.msg, {icon: 2});
                        }
                    })
                    .catch(requestError)
            } catch (e) {
                layer.msg(e, {icon: 5});
            }
        },
        classifyEdit: function (id) {
            let classifyName = $("#classifyName").val();
            let sort = $("#sort").val();
            let arr = [classifyName, sort];
            let data = {
                id: id,
                title: classifyName,
                sort: sort
            };
            let request = requestMethod('POST', data);
            try {
                is_empty(id);
                proString(arr);
                fetch('classifyEdit', request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1});
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        } else {
                            layer.msg(res.msg, {icon: 2});
                        }
                    })
                    .catch(requestError)
            } catch (e) {
                layer.msg(e, {icon: 5});
            }
        },
        setStatus:function (id) {
            try {
                is_empty(id);
                let data = {
                    id: id
                };
                let request = requestGet('setStatus', data);
                fetch(request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1) {
                            layer.msg(res.msg, {icon: 1});
                            setTimeout(function () {window.location.reload();},2000)
                        } else {
                            layer.msg(res.msg, {icon: 2});
                        }
                    })
                    .catch(requestError)
            }catch (e) {

            }
        },
        classifyDel: function (id) {
            layer.confirm("确定要删除吗?此方法不可逆!", {title: '提示', icon: 3}, function (index) {
                if (index) {
                    try {
                        is_empty(id);
                        let data = {id: id};
                        let request = requestGet('classifyDel', data);
                        fetch(request)
                            .then(requestHandle)
                            .then(res => {
                                if (res.code == 1) {
                                    layer.msg(res.msg, {icon: 1});
                                    setTimeout(function () {window.location.reload();},2000)
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
    }
});