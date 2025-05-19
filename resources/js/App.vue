<template>
    <RouterView />
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router';
import { useAuthStore } from './store/auth';
import { onMounted } from 'vue';
import { getAuthStatus } from './utils/auth';

const authStore = useAuthStore();

onMounted(async () => {
    const localStorageAuthStatus = getAuthStatus();

    if (localStorageAuthStatus) {
        authStore.isLogined = localStorageAuthStatus;
    }

    await authStore.fetchAuthUser();
    

});

</script>