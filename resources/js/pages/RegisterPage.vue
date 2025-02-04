<template>
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
import {IRegisterForm} from "../types/user";

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
