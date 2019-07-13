let task = new Vue({
    el:'#task',
    data:{
        task:[],
        width:{
            width: 0
        }
    },
    created:function () {
        this.taskList();
    },
    methods:{
        taskList:function(){
            try {
                let request = requestMethod('GET',{});
                fetch('task',request)
                    .then(requestHandle)
                    .then(res => {
                        task.task = res.msg;
                        task.width.width = res.msg.width + '%';
                    })
                    .catch(requestError)
            }catch (err) {
                layer.msg(err,{icon:5});
            }
        },
        getReward:function(){
            try{
                let request = requestMethod('GET',{});
                fetch()
                    .then(requestHandle)
                    .then()
                    .catch(requestError)
            }catch (err) {
                layer.msg(err,{icon:5});
            }
        }
    }
});