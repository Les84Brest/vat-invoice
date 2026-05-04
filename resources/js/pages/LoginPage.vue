<template>
    <AuthLayout>
        <h1 class="auth__title">
            Вход
        </h1>
        <el-form ref="loginFormRef" :rules="rules" :model="loginData" label-position="left" label-width="auto"
            require-asterisk-position="left">
            <el-form-item label="Email" prop="email">
                <el-input type="email" v-model="loginData.email" placeholder="example@bstu.by" />
            </el-form-item>
            <el-form-item label="Пароль" prop="password">
                <el-input type="password" v-model="loginData.password" />
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitLogin(loginFormRef)" :loading="isLoading">
                    {{ isLoading ? 'Загрузка...' : 'Войти' }}
                </el-button>
            </el-form-item>
        </el-form>
        
        <el-alert
            v-if="errorMessage"
            :title="errorMessage"
            type="error"
            closable
            @close="errorMessage = ''"
            style="margin-top: 16px;"
        />

        <el-text>Для создания учетной записи перейдите на <RouterLink to="/register">страницу регистрации</RouterLink>
        </el-text>

    </AuthLayout>
</template>

<script setup lang="ts">
import AuthLayout from "@/layouts/AuthLayout.vue";
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/store/auth';
import type { FormInstance } from 'element-plus';
import { ElMessage } from 'element-plus';
import type { ILoginForm } from '@/types/user';

const router = useRouter();
const authStore = useAuthStore();
const loginFormRef = ref<FormInstance>();

const loginData = reactive<ILoginForm>({
    email: '',
    password: '',
});

const isLoading = ref(false);
const errorMessage = ref('');

const rules = {
    email: [
        { required: true, message: 'Email обязателен', trigger: 'blur' },
        { type: 'email', message: 'Введите корректный email', trigger: 'blur' },
    ],
    password: [
        { required: true, message: 'Пароль обязателен', trigger: 'blur' },
        { min: 6, message: 'Пароль должен быть не менее 6 символов', trigger: 'blur' },
    ],
};

const submitLogin = async (formEl: FormInstance | undefined) => {
    if (!formEl) return;

    errorMessage.value = '';
    isLoading.value = true;

    try {
        await formEl.validate();

        const success = await authStore.loginIn(loginData);

        if (success) {
            ElMessage.success('Успешный вход');
            // Redirect to main dashboard
            await router.push({ name: 'vat.dashboard' });
        }
    } catch (error: any) {
        errorMessage.value = error.message || 'Ошибка входа. Попробуйте еще раз.';
        console.error('Login error:', error);
    } finally {
        isLoading.value = false;
    }
};
</script>
