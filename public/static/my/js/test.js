let Index = new Vue({
    el: '#index',
    data: {
        CURD: {}
    },
    created: function () {
        this.CURD = Object.create(CURD);
    },
    methods: {
        getData: function () {
            console.log(Index.CURD.methods.getName('123'));
        }
    }
});
