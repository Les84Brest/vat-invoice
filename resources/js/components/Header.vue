<template>
    <el-header class="app-header">
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