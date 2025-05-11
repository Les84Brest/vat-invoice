<template>
    <el-table :data="props.invoicesList" v-loading="isLoading" style="width: 100%" border empty-text="Нет данных">
        <el-table-column type="index" :index="startingIndex" label="№ п/п" width="45" />
        <el-table-column prop="recipient_company.tax_id" label="УНП получателя" width="100" />
        <el-table-column prop="recipient_company.title" label="Наименование получателя" />
        <el-table-column prop="number" label="Номер">
            <template #default="scope">
                <router-link :to="`/vat/invoice/${scope.row.id}`">{{ scope.row.number }}</router-link>
            </template>
        </el-table-column>
        <el-table-column prop="status" label="Статус">
            <template #default="scope">
                <InvoiceStatus :status="scope.row.status" />
            </template>
        </el-table-column>
        <el-table-column prop="type" label="Тип">
            <template #default="scope">
                <InvoiceType :type="scope.row.type" />
            </template>
        </el-table-column>

        <el-table-column prop="action_date" label="Дата совершения" width="100" />
        <el-table-column prop="creation_date" label="Дата выставления" width="100" />
        <el-table-column prop="author.full_name" label="Автор" width="120" />
        <el-table-column prop="total_wo_vat" label="Итоговая сумма НДС, рублей" />
        <el-table-column prop="total" label="Итоговая сумма с НДС, рублей" />

        <el-table-column min-width="70" label="Действия">
            <template #default="scope">
                <InvoiceTableRowActions invoiceId="scope.row.id" :alowedActions="props.allowedActions" />
            </template>
        </el-table-column>
    </el-table>
    <el-pagination background :page-size="10" layout="prev, pager, next" :total="invoiceStore.totalInvoices"
        @current-change="handlePageChange" hide-on-single-page />
    <PasswordConfirmDialog @user-password-confirmed="handlePasswordConfirmed" />
</template>
<script setup lang="ts">
import { Invoice } from '@/types/invoice';
import { useRouter } from 'vue-router';
import { ref, computed } from 'vue';
import { MoreFilled, More, EditPen, View, Select, Failed } from '@element-plus/icons-vue';
import { useInvoiceStore } from '@/store/invoice';
import InvoiceTableRowActions from '@components/invoice/InvoiceTableRowActions.vue';
import InvoiceStatus from '@components/invoice/InvoiceStatus.vue';
import InvoiceType from "@components/invoice/InvoiceType.vue";
import { InvoiceAlowedActions } from '@/types/invoiceTable';

const props = defineProps<
    {
        invoicesList: Array<Invoice>,
        isLoading: boolean,
        allowedActions: Array<InvoiceAlowedActions>
    }
>();

const ALOWED_ACTIONS = [
    InvoiceTableRowActions
];

const invoiceStore = useInvoiceStore();
const router = useRouter();

const isLoading = ref<boolean>(false);
const startingIndex = computed(() => {
    return (invoiceStore.currentPage - 1) * 10 + 1;
});


function handlePageChange(page: number) {
    invoiceStore.fetchCurrentInvoices(page);
}
function handlePasswordConfirmed() {
    console.log('%cpassword confirmed', 'padding: 5px; background: DarkKhaki; color: Yellow;');
}
</script>