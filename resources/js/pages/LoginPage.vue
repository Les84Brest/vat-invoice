<template>
    <!-- <div class="container">
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
    </div> -->

    <el-container>
        <el-form ref="loginFormRef" :rules="rules" :model="loginData" label-position="left" label-width="auto"
            require-asterisk-position="left">
            <el-form-item label="Email" prop="email">
                <el-input type="email" v-model="loginData.email" placeholder="example@bstu.by" />
            </el-form-item>
            <el-form-item label="Пароль" prop="password">
                <el-input type="password" v-model="loginData.password" />
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitLogin(loginFormRef)">
                    Войти
                </el-button>
            </el-form-item>

        </el-form>

    </el-container>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import axios from 'axios';
import type { FormInstance, FormRules } from 'element-plus'

const loginFormRef = ref<FormInstance>();

interface ILoginForm {
    email: string,
    password: string
}

const loginData = reactive<ILoginForm>(
    {
        email: '',
        password: ''
    }
);

const rules = reactive<FormRules<ILoginForm>>({
    email: [
        { required: true, message: 'Поле email не должно быть пустым', trigger: 'blur' },
        {
            pattern: /^\S+@\S+\.\S+$/,
            message: 'Введите корректный email',
            trigger: 'blur',
        }
    ],
    password: [
        {
            required: true,
            message: 'пароль не должен быть пустым',
            trigger: 'change',
        },
        {
            min: 6,
            message: "Длина пароля должна быть больше шести знаков",
            trigger: 'blur'
        }
    ]
});



function submitLogin(formEl: FormInstance | undefined) {
    if (!formEl) return;

    formEl.validate((valid) => {
        if (valid) {
            axios.get('/sanctum/csrf-cookie')
                .then((response) => {
                    if (response.status === 204) {
                        window.localStorage.setItem('auth', 'true');
                    }

                    axios.post('/login', loginData)
                        .then((data) => {
                            console.log('%cdata', 'padding: 5px; background: DarkKhaki; color: Yellow;', data);
                        })
                })
        } else {
            console.log('error submit!')
        }
    })
}

</script>

<!-- <script lang="ts">
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

</script> -->