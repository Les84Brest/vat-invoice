<template>
    <div class="container">
        <div class="row">
            <h2>User registration</h2>
            <div class="login w-50 p-3">
                <div class="mb-3">
                    <label for="exampleInput123" class="form-label">User name</label>
                    <input v-model="name" type="text" class="form-control" id="exampleInput123"
                        aria-describedby="emailHelpUserName">
                    <div id="emailHelpUserName" class="form-text">Enter user name please</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input v-model="email" type="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input v-model="password" type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword12" class="form-label">Password confirmation</label>
                    <input v-model="password_confirmation" type="password" class="form-control" id="exampleInputPassword12">
                </div>
                <button @click="register" class="btn btn-primary">Create User</button>
            </div>

        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'WelcomeRegisterPage',
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        }
    },
    methods: {
        register() {
            axios.get('/sanctum/csrf-cookie')
                .then((cookieData) => {
                    axios.post('/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    })
                        .then((data) => {
                            console.log('%cregister data', 'padding: 5px; background: DarkGreen; color: MediumSpringGreen;', data);
                        })
                });
        },
        login() {
            axios.get('/sanctum/csrf-cookie')
                .then((resp) => {
                    console.log('%cresp', 'padding: 5px; background: hotpink; color: black;', resp);
                    axios.post('/login', { email: this.email, password: this.password })
                        .then((data) => {
                            console.log('%cdata', 'padding: 5px; background: hotpink; color: black;', data);
                        })
                })

        },

    }
}

</script>