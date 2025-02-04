<template>
    <el-card style="max-width: 100%">
        <div class="invoice__actions">
            <el-button type="primary" :icon="Filter"  @click="isFilterOpen = !isFilterOpen"/>
            <RouterLink :to="{ name: 'vat.newInvoice' }" class="el-button el-button--success invoice__btn">Создать ЭСЧФ
            </RouterLink>
        </div>
    </el-card>

    <el-drawer v-model="isFilterOpen" title="Фильтр" direction="rtl">
        <span>Фильтр по ЭСЧФ</span>
    </el-drawer>
</template>


<script setup lang="ts">
import { ref } from "vue";
import { Filter } from "@element-plus/icons-vue";
import { RouterLink } from 'vue-router';

const isFilterOpen = ref<boolean>(false);

</script>
<style scoped>
.invoice__actions {
    display: flex;
    justify-content: flex-end;
}

.invoice__btn {
    text-decoration: none;
}
</style>