<template>
    <!-- <div class="container">
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
    </div> -->
    <el-container>
        <el-form ref="registerFormRef" :rules="rules" :model="registerData" label-position="left" label-width="auto"
            require-asterisk-position="left">
            <el-form-item label="Имя" prop="name">
                <el-input v-model="registerData.name" placeholder="Введите имя" />
            </el-form-item>
            <el-form-item label="Фамилия" prop="last_name">
                <el-input v-model="registerData.last_name" placeholder="Введите фамилию" />
            </el-form-item>
            <el-form-item label="Email" prop="email">
                <el-input type="email" v-model="registerData.email" placeholder="example@bstu.by" />
            </el-form-item>
            <el-form-item label="Пароль" prop="password">
                <el-input type="password" v-model="registerData.password" />
            </el-form-item>
            <el-form-item label="Подтверждение пароля" prop="password_confirmation">
                <el-input type="password" v-model="registerData.password_confirmation" />
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitRegister(registerFormRef)">
                    Создать пользователя
                </el-button>
            </el-form-item>

        </el-form>
    </el-container>
</template>
<script setup lang="ts">
import { reactive, ref } from 'vue';
import type { FormInstance, FormRules, FormValidateCallback } from 'element-plus'
import axios from 'axios';

interface IRegisterForm {
    name: string,
    last_name: string,
    email: string,
    password: string
    password_confirmation: string
}

const registerFormRef = ref<FormInstance>();

const registerData = reactive<IRegisterForm>({
    name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

function validationConfirmPassword(rule: any, value: any, callback: (error?: Error) => void) {
    if (value === '') {
        callback(new Error("Пожалуйста подтвердите пароль"));
    } else if (value !== registerData.password) {
        callback(new Error("Введенные пароли не совпадают"))
    } else {
        callback();
    }
}

const rules = reactive<FormRules<IRegisterForm>>({
    name: [
        { required: true, message: "Введите имя", trigger: 'blur' }
    ],

    last_name: [
        { required: true, message: "Введите фамилию", trigger: 'blur' }
    ],

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
    ],
    password_confirmation: [
        {
            required: true,
            message: 'Подтвердите пароль',
            trigger: 'change',
        },
        {
            required: true,
            validator: validationConfirmPassword
        }
    ]
});

function submitRegister(formEl: FormInstance | undefined) {
    if (!formEl) return;

    formEl.validate((valid) => {
        if (valid) {
            axios.get('/sanctum/csrf-cookie')
            .then( (data) => {
                console.log('%cdata', 'padding: 5px; background: hotpink; color: black;', data);
            })
        } else {
            console.log('%cregistation error', 'padding: 5px; background: hotpink; color: black;');
        }
    });
}
</script>

<!-- <script>
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

</script> -->