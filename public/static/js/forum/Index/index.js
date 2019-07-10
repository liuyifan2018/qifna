let project = new Vue({
    el: '#project',
    data: {
        lists: [],
    },
    created: function () {
        this.listsIndex();  //加载主页数据
    },
    methods: {
        listsIndex: function () {
            try {
                let request = requestMethod('GET', {});
                fetch('lists', request)
                    .then(requestHandle)
                    .then(res => {
                        project.lists = [];
                        if (res.msg != []){
                            this.forRes(res.msg);
                        }
                    })
                    .catch(requestError);
            } catch (err) {
                layer.msg(err, {icon: 5});
            }
        },
        classify: function (classify) {
            try {
                let data = {classify: classify};
                let that = this;
                $.ajax({
                    url: 'lists',
                    type: 'GET',
                    data: data,
                    success: function (res) {
                        project.lists = [];
                        if (res.msg != []){
                            that.forRes(res.msg);
                        }
                    },
                    error: function (err) {
                        console.log(err);
                        layer.msg(err, {icon: 5});
                    }
                });
            } catch (err) {
                console.log(err);
                layer.msg(err, {icon: 5});
            }
        },
        forRes: function (msg) {
            for (let i = 0; i < msg.length; i++) {
                project.lists.push(msg[i]);
            }
        },
        noteInfo: function (id) {
            is_empty(id);
            window.location.href = "http://localhost/Qifan/public/index.php/forum/note/note.html?id=" + id;
        }
    }
});
