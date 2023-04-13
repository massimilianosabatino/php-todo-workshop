const { createApp } = Vue;

createApp({
    data(){
        return {
            apiUrl: 'server.php',
            // todos: [
            //     {
            //         "text": "HTML",
            //         "done": true
            //     },
            //     {
            //         "text": "CSS",
            //         "done": true
            //     },
            //     {
            //         "text": "Responsive design",
            //         "done": true
            //     },
            //     {
            //         "text": "Javascript",
            //         "done": true
            //     },
            //     {
            //         "text": "PHP",
            //         "done": true
            //     },
            //     {
            //         "text": "Laravel",
            //         "done": false
            //     }
            // ],
            todos: [],
        }
    },
    methods: {
        getTodos(){
            axios.get(this.apiUrl).then(response => {
                console.log(response);
                this.todos = response.data;
            })
        }
    },
    created(){
        this.getTodos();
        console.log(this.todos);
    }
}).mount('#app');