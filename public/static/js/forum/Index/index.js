let project = new Vue({
    el:'#project',
    data:{
        lists:[],
        hotNotes:[]
    },
    created:function () {
        this.listsIndex();  //加载主页数据
    },
    methods:{
        listsIndex:function(){
            try {
                let request = requestMethod('lists','GET',null);
                fetch(request)
                    .then(requestHandle)
                    .then(res => {
                        for (let i = 0; i < res.msg.lists.length; i++){
                            project.lists.push(res.msg.lists[i]);
                        }
                        for (let i = 0; i < res.msg.hotNotes.length; i++){
                            project.hotNotes.push(res.msg.hotNotes[i]);
                        }
                    })
                    .catch(requestError);
            }catch (err) {
                layer.msg(err,{icon:5});
            }
        }
    }
});
