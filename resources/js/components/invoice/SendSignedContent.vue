<template>
    <InvoiceActions />
    <el-card class="invoices-table-card">
        <h3>Отправленные подписанные ЭСЧФ</h3>

        <SendedInvoicesTable :invoicesList="invoiceStore.invoices" :isLoading="isLoading"
            :allowedActions="ALLOWED_ACTIONS" />
    </el-card>
</template>
<script setup lang="ts">
import { useInvoiceStore } from '@/store/invoice';
import { InvoiceAlowedActions } from '@/types/invoiceTable';
import { onMounted, ref } from 'vue';
import InvoiceActions from './InvoiceActions.vue';
import SendedInvoicesTable from './SendedInvoicesTable.vue';

const ALLOWED_ACTIONS = [
    InvoiceAlowedActions.PREVIEW_INVOICE,
    InvoiceAlowedActions.CANCEL_INVOICE,
];

const invoiceStore = useInvoiceStore();

const isLoading = ref<boolean>(false);

onMounted(() => {
    invoiceStore.fetchSendInvoices();
    invoiceStore.currentFetchFunctionName = 'fetchSendInvoices';
})

</script>