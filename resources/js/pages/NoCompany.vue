<template>
    <AuthLayout>
        <h1 class="auth__title">
            Вам не назначена компания <br /> Обратитесь к преподавателю
        </h1>

        <div>
            Для продолжения работы с порталом:
            <ol class="no-company__list-actions">
                <li>Обратитель к преподавателю с просьбой назначить вам компанию</li>
                <li>Дождитесь, когда компания будет назначена</li>
                <li>Перезагрузите страницу в браузере (<strong>F5</strong> или <strong>Ctrl+R</strong>)</li>
            </ol>

            <el-button type="primary" plain @click="onUnlogin">Выйти</el-button>

        </div>


    </AuthLayout>
</template>

<script setup lang="ts">
import AuthLayout from "@/layouts/AuthLayout.vue";
import { useAuthStore } from "@/store/auth";
import { onMounted } from "vue";
import { useRouter } from "vue-router";
import { getCompanyAssigmentStatus } from "@/utils/auth";

const authStore = useAuthStore();
const router = useRouter();

onMounted(() => {
    const assignedCompanyStatus = getCompanyAssigmentStatus();
    if (assignedCompanyStatus) {
        router.push({ name: "vat.dashboard" });

        return;
    }

})


function onUnlogin() {
    authStore.logOut();
    router.push('/login');
}


</script>

<style scoped lang="scss">
.no-company__list-actions {
    margin-top: 12px;
    list-style: decimal;

    li {
        margin-bottom: 12px;
    }
}
</style>