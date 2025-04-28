<template>
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
        <el-text>Для создания учетной записи перейдите на <RouterLink to="/register">страницу регистрации</RouterLink>
            </el-text>

    </el-container>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import type { FormInstance, FormRules } from 'element-plus';
import { ILoginForm } from "../types/user";
import { useAuthStore } from "../store/auth";
import { useRouter, RouterLink } from 'vue-router';

const loginFormRef = ref<FormInstance>();
const authStore = useAuthStore();

const router = useRouter();


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


async function submitLogin(formEl: FormInstance | undefined) {
    if (!formEl) return;

    await formEl.validate(async (valid) => {
        if (valid) {
            await authStore.loginIn(loginData);
            router.push('/vat');
        } else {
            console.log('error submit!')
        }
    })
}

</script>
