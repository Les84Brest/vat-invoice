<template>
    <el-header class="app-header">
        <!-- <el-page-header title="Назад">

            <template #content>
                <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                    <span class="text-large font-600 mr-3"> Неподписанные счета-фактуры</span>
                    <div class="app-header-info">
                        <el-avatar>ПВ</el-avatar>
                    </div>
                </div>
            </template>

            <template #breadcrumb>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item :to="{ path: './page-header.html' }">
                        Главная
                    </el-breadcrumb-item>
                    <el-breadcrumb-item>
                        <a href="./page-header.html">route 1</a>
                    </el-breadcrumb-item>
                    <el-breadcrumb-item>Счета</el-breadcrumb-item>
                </el-breadcrumb>
            </template>
        </el-page-header> -->
        <div class="header__content" v-if="authStore.user">
            <div class="header__left">
                <el-button :icon="ArrowLeftBold"></el-button>
            </div>
            <div class="header__right">
                <div class="header__company company-header">
                    <div class="company-header__name"><el-text>{{ authStore.user.company.title }}</el-text></div>
                    <div class="company-header__taxid"><el-text>УНП: {{ authStore.user.company.tax_id }}</el-text></div>
                </div>
                <div class="header__user user-header">
                    <div class="user-header__name">{{ authStore.user.full_name }}</div>
                    <el-dropdown @command="handleUserDropdown">
                        <el-avatar>{{ avatarString }}</el-avatar>
                        <template #dropdown>
                            <el-dropdown-item command="user_logout">Выйти</el-dropdown-item>
                        </template>
                    </el-dropdown>

                </div>

            </div>
        </div>
    </el-header>
</template>

<script setup lang="ts">
import { computed, onBeforeMount } from 'vue';
import { ArrowLeftBold } from "@element-plus/icons-vue";
import { useAuthStore } from "../store/auth";
import { getAuthStatus } from '../utils/auth';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const isLogined = getAuthStatus();
const router = useRouter();

console.log('%cstate', 'padding: 5px; background: hotpink; color: black;', authStore.user);

const handleUserDropdown = (command: string | number | object) => {
    if (command === 'user_logout') {
        authStore.logOut();
        router.push('/login');
    }
}

const avatarString = computed(() => {
    if (authStore.user) {
        const abbr = authStore.user.last_name.charAt(0) + authStore.user.name.charAt(0);
        return abbr.toUpperCase();
    }

    return '';
});

onBeforeMount(async () => {
    if (isLogined && !authStore.user) {
        await authStore.fetchAuthUser();
        authStore.isLogined = true;
    }
})

</script>