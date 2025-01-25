<template>
    <div class="container">
        <div class="row">
            <h2>Login</h2>
            <div class="login w-50 p-3">
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
                <button @click="login" class="btn btn-primary">Submit</button>
            </div>
            <div class="some">
                <button class="btn btn-primary" @click="getData">get data</button>
            </div>
        </div>
        <div class="row">
            <el-button type="warning">Какая-то кнопка</el-button>
        </div>
    </div>
</template>

<script lang="ts">
import axios from 'axios';
import { ElButton } from 'element-plus';

export default {
    name: 'WelcomeLoginPage',
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie')
                .then((resp) => {
                    console.log('%ctoken', 'padding: 5px; background: hotpink; color: black;', resp);
                    if (resp.status === 204) {
                        window.localStorage.setItem('auth', 'true');
                    }
                    axios.post('/login', { email: this.email, password: this.password })
                        .then((data) => {
                            console.log('%cdata', 'padding: 5px; background: hotpink; color: black;', data);
                        })
                })

        },
        getData() {
            axios.get('/api/get')
                .then((data) => {
                    console.log('%cget data', 'padding: 5px; background: crimson; color: white;', data);
                })
        }
    }
}

</script>