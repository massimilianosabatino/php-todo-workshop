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
            newTodo: '',
            // Login form
            logged: false,
            username: '',
            password: ''
        }
    },
    methods: {
        getTodos(){
            //Get only for this user
            const headers = {
                username: this.username
            };
            console.log('sent headers', headers);

            axios.get(this.apiUrl, { headers }).then(response => {
                console.log(response);
                this.todos = response.data;
            })
        },
        addTodo(){
            const data = {
                add: true,
                todo: this.newTodo,
                username: this.username,
            };

            const headers = {
                'Content-Type' : 'multipart/form-data',
                'Accept': 'application/json',
                username: this.username,
            };

            axios.post(this.apiUrl, data, {headers}).then(response => {
                console.log(response)
                this.todos = response.data;
            });
            this.newTodo = '';
        },
        removeTodo(i){
            const data = {
                delete: i,
            };

            const headers = {
                'Content-Type' : 'multipart/form-data',
                'Accept': 'application/json',
                username: this.username,
            };

            axios.post(this.apiUrl, data, {headers}).then(response => {
                console.log(response)
                this.todos = response.data;
            });
        },
        login(){
            const data = {
                action: 'login',
                username: this.username,
                password: this.password,
            };
            const headers = {
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json',
            }
            axios.post(this.apiUrl, data, { headers }).then((response) => {
                console.log('login response', response.data);
                if (response.data.username) {
                    this.logged = true;
                    this.getTodos();
                    sessionStorage.setItem("log-status", true);
                    sessionStorage.setItem("user-logged", response.data.username);
                } else {
                    alert('Utente non trovato.');
                }
            })
        },
        logOut(){
            sessionStorage.clear();
            location.reload();
        }
    },
    created(){
        if (sessionStorage.getItem("log-status") === "true") {
            this.logged = sessionStorage.getItem("log-status");
            this.username = sessionStorage.getItem("user-logged");
        }
        this.getTodos();
        console.log('this.todos', this.todos);
    }
}).mount('#app');