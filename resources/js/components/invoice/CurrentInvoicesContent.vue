<template>
    <InvoiceActions />
    <el-card>
        <h3>В работе (черновики)</h3>

        <el-table :data="invoiceStore.invoices" v-loading="isLoading" style="width: 100%" border empty-text="Нет данных">
            <el-table-column type="index" label="№ п/п" width="45" />
            <el-table-column prop="recipient_company.tax_id" label="УНП получателя" width="100" />
            <el-table-column prop="recipient_company.title" label="Наименование получателя" />
            <el-table-column prop="number" label="Номер" />
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

            <el-table-column min-width="70">
                <template #default="scope">
                    <el-dropdown trigger="click">
                        <span class="el-dropdown-link">
                            <el-icon>
                                <MoreFilled />
                            </el-icon>

                        </span>
                        <template #dropdown>
                            <el-dropdown-menu trigger="click">
                                <el-dropdown-item :icon="View">Просмотр</el-dropdown-item>
                                <el-dropdown-item :icon="EditPen" divided>Редактировать</el-dropdown-item>
                                <el-dropdown-item :icon="Select" divided>Подписать</el-dropdown-item>
                                <el-dropdown-item :icon="Failed" divided>Анулировать</el-dropdown-item>

                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination background :page-size="10" layout="prev, pager, next" :total="1000"
            @current-change="handlePageChange" @size-change="handleSizeChange" hide-on-single-page />
    </el-card>
</template>
<script setup lang="ts">
import { useRouter } from 'vue-router';
import { useInvoiceStore } from '@/store/invoice';
import { ref, onMounted } from 'vue';
import { MoreFilled, EditPen, View, Select, Failed } from '@element-plus/icons-vue';
import InvoiceStatus from '@components/invoice/InvoiceStatus.vue';
import InvoiceType from './InvoiceType.vue';

import InvoiceActions from './InvoiceActions.vue';

const router = useRouter();
const invoiceStore = useInvoiceStore();

const isLoading = ref<boolean>(false);

function handleSizeChange(page: number) {
    console.log('%cpage', 'padding: 5px; background: DarkKhaki; color: Yellow;', page);
}
function handlePageChange(page: number) {
    console.log('%cpage', 'padding: 5px; background: #3dd; color: #333333;', page);
}

onMounted(() => {
    invoiceStore.fetchCurrentInvoices();
})
</script>