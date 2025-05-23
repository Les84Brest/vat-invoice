<template>
    <InvoiceActions />
    <el-card class="invoices-table-card">
        <h3>В работе (черновики)</h3>

        <el-table :data="invoiceStore.invoices" v-loading="isLoading" style="width: 100%" border empty-text="Нет данных" show-summary :summary-method="tableSumFunction">
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
            <el-table-column prop="total_wo_vat" label="Итоговая сумма НДС, рублей">
                <template #default="scope">
                    {{ formatCurrency(scope.row.total_wo_vat) }}
                </template>
            </el-table-column>
            <el-table-column prop="total_vat" label="Cумма НДС, рублей">
                <template #default="scope">
                    {{ formatCurrency(scope.row.total_vat) }}
                </template>
            </el-table-column>
            <el-table-column prop="total" label="Итоговая сумма с НДС, рублей">
                <template #default="scope">
                    {{ formatCurrency(scope.row.total) }}
                </template>
            </el-table-column>

            <el-table-column min-width="70" label="Действия">
                <template #default="scope">
                    <el-dropdown trigger="click">
                        <span class="el-dropdown-link">
                            <el-button :icon="MoreFilled" />
                        </span>
                        <template #dropdown>
                            <el-dropdown-menu trigger="click">
                                <el-dropdown-item :icon="View"
                                    @click="router.push(`invoice/${scope.row.id}`)">Просмотр</el-dropdown-item>
                                <el-dropdown-item :icon="EditPen" divided
                                    @click="router.push(`invoice/${scope.row.id}/edit`)">Редактировать</el-dropdown-item>
                                <el-dropdown-item :icon="Select" divided
                                    @click="onSumbitInvoice(scope.row.id)">Подписать</el-dropdown-item>
                                <!-- <el-dropdown-item :icon="Failed" divided>Анулировать</el-dropdown-item> -->

                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination background :page-size="10" layout="prev, pager, next" :total="invoiceStore.totalInvoices"
            @current-change="handlePageChange" @size-change="handleSizeChange" hide-on-single-page />
    </el-card>
    <PasswordConfirmDialog @user-password-confirmed="handlePasswordConfirmed" />
</template>
<script setup lang="ts">
import { useRouter } from 'vue-router';
import { useInvoiceStore } from '@/store/invoice';
import { ref, onMounted, computed, h } from 'vue';
import { MoreFilled, EditPen, View, Select, Failed } from '@element-plus/icons-vue';
import InvoiceStatus from '@components/invoice/InvoiceStatus.vue';
import InvoiceType from './InvoiceType.vue';
import PasswordConfirmDialog from './PasswordConfirmDialog.vue';
import InvoiceActions from './InvoiceActions.vue';
import { ElNotification } from 'element-plus';
import { formatCurrency } from '@/utils/format';
import axios from 'axios';
import useVatTableSummaries from '@/composables/useVatTableSummaries';

const router = useRouter();
const invoiceStore = useInvoiceStore();

const NOT_SUMMARIZED_COLUMNS = [
    'author.full_name',
    'creation_date',
    'action_date',
    'type',
    'status',
    'number',
    'recipient_company.title',
    'recipient_company.tax_id',
];

const tableSumFunction = useVatTableSummaries(NOT_SUMMARIZED_COLUMNS, " ");

const isLoading = ref<boolean>(false);
const startingIndex = computed(() => {
    return (invoiceStore.currentPage - 1) * 10 + 1;
});

function handleSizeChange(page: number) {
    console.log('%cpage', 'padding: 5px; background: DarkKhaki; color: Yellow;', page);
}
function handlePageChange(page: number) {
    invoiceStore.fetchCurrentInvoices(page);
}

onMounted(() => {
    invoiceStore.fetchCurrentInvoices();
})

//submit invoice
const isSubmitButtonPressed = ref<boolean>(false);
const submittedInvoiceId = ref<number | null>(null);

function onSumbitInvoice(invoiceId: number) {
    submittedInvoiceId.value = invoiceId;
    isSubmitButtonPressed.value = true;
    invoiceStore.togglePasswordConfirmVisible();
}


function handlePasswordConfirmed(payload: { isConfirmed: boolean }) {
    if (!isSubmitButtonPressed.value) {
        return;
    }

    const { isConfirmed } = payload;

    if (!isConfirmed) {
        ElNotification({
            title: 'Пароль не подтвержден',
            message: h('i', { style: 'color: teal' }, 'Неправильный пароль'),
            type: 'error',
        });
        isSubmitButtonPressed.value = false;

        return;
    }

    axios.post('/api/v1/invoice/submit-invoice', { id: submittedInvoiceId.value }, {
        headers: {
            'Content-Type': 'application/json'
        }
    }).then((data) => {
        ElNotification({
            title: 'Счет подписан',
            message: h('i', { style: 'color: teal' }, "Счет подписан и отправлен получателю"),
            type: "success",
        });
        isSubmitButtonPressed.value = false;
        setTimeout(() => {
            invoiceStore.fetchCurrentInvoices();
        }, 500);

    });
}
</script>