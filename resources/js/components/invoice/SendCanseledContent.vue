<template>
    <InvoiceActions />
    <el-card class="invoices-table-card">
        <h3>Отправленные аннулированные ЭСЧФ</h3>
        <SendedInvoicesTable :invoicesList="invoiceStore.invoices" :isLoading="isLoading"
            :allowedActions="allowedActions" />

    </el-card>
</template>
<script setup lang="ts">
import { useInvoiceStore } from '@/store/invoice';
import { InvoiceAlowedActions } from '@/types/invoiceTable';
import { onMounted, ref } from 'vue';
import InvoiceActions from './InvoiceActions.vue';
import SendedInvoicesTable from './SendedInvoicesTable.vue';

const allowedActions = [
    InvoiceAlowedActions.PREVIEW_INVOICE
];

const invoiceStore = useInvoiceStore();
const isLoading = ref<boolean>(false);


onMounted(() => {
    invoiceStore.fetchSendCanseledInvoices();
    invoiceStore.currentFetchFunctionName = 'fetchSendCanseledInvoices';
})
</script>