$(function(){
    $(document).keypress(function (e) {
        if (e.keyCode == 13){
            document.getElementById('login').click();
        }
    })
});
$(function () {
    //刷新验证码
    var verifyUrl = '{:captcha_src("admin")}';
    console.log($('#LAY-user-get-vercode'))
    $('#LAY-user-get-vercode').on('click', function () {
        $(this).attr('src', verifyUrl + "?_r=" + new Date().getTime());
    }).click();
});
$(function () {
    $("#login").click(function () {
        try {
            let username = $("#username").val();
            let password = $("#password").val();
            let arr = [username, password];
            let data = {
                username: username,
                password: password
            };
            proString(arr);
            let request = requestMethod('POST', data);
            fetch('login', request)
                .then(requestHandle)
                .then(res => {
                    if (res.code == 1) {
                        setTimeout(function(){
                            window.location.href = res.msg
                        },500)
                    } else {
                        layer.msg(res.msg,{icon:5});
                    }
                })
                .catch(requestError)
        } catch (e) {
            layer.msg(e, {icon: 5});
        }
    })
});

