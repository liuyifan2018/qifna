let project = new Vue({
    el:'#project',
    data:{
        lists:[],
    },
    created:function () {
        this.listsIndex();  //加载主页数据
    },
    methods:{
        listsIndex:function(){
            try {
                let request = requestMethod('GET',{});
                fetch('lists',request)
                    .then(requestHandle)
                    .then(res => {
                        for (let i = 0; i < res.msg.length; i++){
                            project.lists.push(res.msg[i]);
                        }
                    })
                    .catch(requestError);
            }catch (err) {
                layer.msg(err,{icon:5});
            }
        },
        classify:function(classify){
            try {
                let data = { classify:classify };
                let request = requestMethod('GET',data);
                fetch('lists',request)
                    .then(requestMethod)
                    .then(res => {
                        for (let i = 0; i < res.msg.length; i++){
                            project.lists.push(res.msg.lists[i]);
                        }
                    })
                    .catch(requestError);
            }catch (err) {
                console.log(err);
                layer.msg(err,{icon: 5});
            }
        }
    }
});
