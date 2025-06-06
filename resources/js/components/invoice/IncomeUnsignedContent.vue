<template>
    <InvoiceActions />
    <el-card class="invoices-table-card">
        <h3>Входящие неподписанные ЭСЧФ</h3>
        <IncomeInvoicesTable :invoices-list="invoiceStore.invoices" :isLoading="isLoading"
            :allowedActions="allowedActions" />
    </el-card>
    <!-- <PasswordConfirmDialog @user-password-confirmed="handlePasswordConfirmed" />
    <PasswordConfirmDialog @user-password-confirmed-cansel="handlePasswordConfirmedCanselInvoice" /> -->
</template>
<script setup lang="ts">
import { useInvoiceStore } from '@/store/invoice';
import { InvoiceAlowedActions } from '@/types/invoiceTable';
import { onMounted, ref } from 'vue';
import IncomeInvoicesTable from './IncomeInvoicesTable.vue';
import InvoiceActions from './InvoiceActions.vue';

const allowedActions: Array<InvoiceAlowedActions> = [
    InvoiceAlowedActions.PREVIEW_INCOME_INVOICE,
    InvoiceAlowedActions.SIGN_INVOICE,
];

const invoiceStore = useInvoiceStore();
const isLoading = ref<boolean>(false);

onMounted(() => {
    invoiceStore.fetchIncomeUnsignedInvoices();
})

</script>