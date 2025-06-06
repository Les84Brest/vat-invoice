<template>
    <InvoiceActions />
    <el-card class="invoices-table-card">
        <h3>Входящие аннулированные ЭСЧФ</h3>

        <IncomeInvoicesTable :invoices-list="invoiceStore.invoices" :isLoading="isLoading"
            :allowedActions="allowedActions" />
    </el-card>
</template>
<script setup lang="ts">
import { useInvoiceStore } from '@/store/invoice';
import { onMounted, ref } from 'vue';
import InvoiceActions from './InvoiceActions.vue';
import { InvoiceAlowedActions } from '@/types/invoiceTable';
import IncomeInvoicesTable from './IncomeInvoicesTable.vue';

const allowedActions: Array<InvoiceAlowedActions> = [
    InvoiceAlowedActions.PREVIEW_INCOME_INVOICE,
];

const invoiceStore = useInvoiceStore();

const isLoading = ref<boolean>(false);

onMounted(() => {
    invoiceStore.fetchIncomeCanseledInvoices();
});

</script>