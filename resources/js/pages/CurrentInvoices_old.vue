<template>
    <AppLayout>
        <InvoiceActions />
        <div class="vat-current-invoices">
            <h1>В работе (черновики)</h1>

            <el-table :data="invoices" v-loading="isLoading" style="width: 100%" border>
                <el-table-column prop="number" label="Number" width="120" />
                <el-table-column prop="creation_date" label="Дата создания" width="150" />
                <el-table-column prop="action_date" label="Дата совершения" width="150" />
                <el-table-column prop="author.name" label="Автор" width="180" />
                <el-table-column prop="recipient_company.name" label="Получатель" width="200" />
                <el-table-column prop="signatory.name" label="ПодписаН" width="180" />

                <el-table-column label="Actions" width="180" fixed="right">
                    <template #default="scope">
                        <el-dropdown @command="handleAction" trigger="click">
                            <el-button type="primary" size="small">
                                Действия<i class="el-icon-arrow-down el-icon--right"></i>
                            </el-button>
                            <template #dropdown>
                                <el-dropdown-menu>
                                    <el-dropdown-item
                                        :command="{ action: 'view', invoice: scope.row }">View</el-dropdown-item>
                                    <el-dropdown-item v-if="scope.row.status === 'PENDING_SIGNATURE'"
                                        :command="{ action: 'sign', invoice: scope.row }">
                                        Sign
                                    </el-dropdown-item>
                                    <el-dropdown-item v-if="scope.row.status === 'DRAFT'"
                                        :command="{ action: 'edit', invoice: scope.row }">
                                        Edit
                                    </el-dropdown-item>
                                    <el-dropdown-item v-if="['DRAFT', 'PENDING_SIGNATURE'].includes(scope.row.status)"
                                        :command="{ action: 'cancel', invoice: scope.row }" divided>
                                        Cancel
                                    </el-dropdown-item>
                                </el-dropdown-menu>
                            </template>
                        </el-dropdown>
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </AppLayout>
</template>

<script lang="ts">
import AppLayout from "@layouts/AppLayout.vue";
import InvoiceActions from "@components/invoice/InvoiceActions.vue";
import { defineComponent, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { ElMessage, ElMessageBox } from 'element-plus';
import { useInvoiceStore } from "@/store/invoice";
import type { Invoice } from '@/types/invoice';

export default defineComponent({
    name: 'VatCurrentInvoices',

    setup() {
        const router = useRouter();
        const invoiceStore = useInvoiceStore();

        const invoices = ref<Invoice[]>([]);
        const isLoading = ref(false);

        const fetchInvoices = async () => {
            try {
                isLoading.value = true;
                invoices.value = await invoiceStore.fetchCurrentInvoices();
                isLoading.value = false;
            } catch (error) {
                ElMessage.error('Не удалось загрузить ЭСЧФ');
                console.error(error);
            } finally {
                isLoading.value = false;
            }
        };

        const handleAction = (command: { action: string; invoice: Invoice }) => {
            const { action, invoice } = command;

            switch (action) {
                case 'view':
                    router.push(`/vat/invoices/${invoice.id}`);
                    break;
                case 'sign':
                    handleSign(invoice);
                    break;
                case 'edit':
                    router.push(`/vat/invoices/${invoice.id}/edit`);
                    break;
                case 'cancel':
                    handleCancel(invoice);
                    break;
            }
        };

        const handleSign = async (invoice: Invoice) => {
            try {
                await ElMessageBox.confirm(
                    `Are you sure you want to sign invoice ${invoice.number}?`,
                    'Confirm Sign',
                    { type: 'warning' }
                );

                await invoiceStore.signInvoice(invoice.id);
                ElMessage.success('Invoice signed successfully');
                await fetchInvoices();
            } catch (error) {
                if (error !== 'cancel') {
                    ElMessage.error('Failed to sign invoice');
                }
            }
        };

        const handleCancel = async (invoice: Invoice) => {
            try {
                await ElMessageBox.confirm(
                    `Are you sure you want to cancel invoice ${invoice.number}?`,
                    'Confirm Cancel',
                    { type: 'warning' }
                );

                await invoiceStore.cancelInvoice(invoice.id);
                ElMessage.success('Invoice cancelled successfully');
                await fetchInvoices();
            } catch (error) {
                if (error !== 'cancel') {
                    ElMessage.error('Failed to cancel invoice');
                }
            }
        };

        onMounted(() => {
            fetchInvoices();
        });

        return {
            invoices,
            isLoading,
            handleAction
        };
    }
});
</script>
