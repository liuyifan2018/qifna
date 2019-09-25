let user = new Vue({
    el: '#user',
    data: {},
    created: function () {

    },
    methods: {
        userInfo: function () {
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
            }
            try {
                proString(arr);
                let request = requestMethod('POST', data);
                fetch('userInfo', request)
                    .then(requestHandle)
                    .then(res => {
                        if (res.code == 1) {
                            layer.msg(res.msg,{icon:1});
                        } else {
                            layer.msg(res.msg,{icon:5});
                        }
                    })
                    .catch(requestError)
            } catch (e) {
                console.log(e);
                layer.msg(e, {icon: 5});
            }
        }
    }
});