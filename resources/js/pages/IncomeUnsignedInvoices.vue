<template>
    <AppLayout>
        <InvoiceActions />
        <el-card>
            <h3>Входящие неподписанные счета-фактуры</h3>
        </el-card>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import InvoiceActions from '@/components/invoice/InvoiceActions.vue';
</script>
