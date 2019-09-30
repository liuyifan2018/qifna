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
                layer.msg(e,{icon:5});
            }
        }
    }
});