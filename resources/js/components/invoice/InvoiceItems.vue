<template>
    <div class="invoice-item__actions">
        <el-button :icon="Plus" type="primary" @click="addItemModalVisible = true">Добавить
            позицию</el-button>
    </div>
    <el-table :data="invoiceItems" show-summary :summary-method="getSummaries" sum-text="Всего" border style="width: 100%"
        empty-text="Добавьте данные">
        <el-table-column type="index" label="№ п/п" width="70" />
        <el-table-column prop="name" label=" Наименование товаров (работ, услуг), имущественных прав" width="200" />
        <el-table-column prop="dimension" label="Единица измерения" width="70" />
        <el-table-column prop="count" label="Количество (объем)" width="100" />
        <el-table-column prop="price"
            label="Цена (тариф) за единицу товара (работы, услуги), имущественных прав без учета НДС, руб." />
        <el-table-column prop="cost" label="Стоимость товаров (работ, услуг), имущественных прав без учета НДС, руб." />
        <el-table-column prop="vat_rate" label="НДС ставка, %" width="100" />
        <el-table-column prop="vat_sum" label="НДС сумма, руб." />
        <el-table-column prop="cost_vat" label=" Стоимость товаров (работ, услуг), имущественных прав с учетом НДС, руб." />

        <el-table-column label="Действия" min-width="70">
            <template #default="scope">
                <el-button type="primary" :icon="Edit" circle @click.prevent="editRow(scope.row.id)" />
                <el-button type="danger" :icon="Delete" circle @click.prevent="deleteRow(scope.row.id)" />
            </template>
        </el-table-column>
    </el-table>
    <template v-if="addItemEditMode">
        <AddEditInvoiceItem :is-visible="addItemModalVisible" @update-isVisible="updateAddItemModalVisible" :item="editItem"
            :edit-mode="addItemEditMode" />
    </template>
    <template v-else>
        <AddEditInvoiceItem :is-visible="addItemModalVisible" @update-isVisible="updateAddItemModalVisible" />
    </template>
</template>
<script setup lang="ts">
import { ref, watch } from 'vue';
import { Delete, Edit, Plus } from '@element-plus/icons-vue';
import AddEditInvoiceItem from './AddEditInvoiceItem.vue';
import { useInvoiceStore } from "@/store/invoice";
import type { TableColumnCtx } from 'element-plus'
import type { InvoiceItem } from '@/types/invoice';


interface SummaryMethodProps<T = InvoiceItem> {
    columns: TableColumnCtx<T>[]
    data: T[]
}

const NOT_SUMMARIZE_COLUMNS = [
    'count',
    'dimension',
    'name',
    'price',
    'vat_rate'
];

const addItemModalVisible = ref<boolean>(false);

function getSummaries(param: SummaryMethodProps) {
    const { columns, data } = param;
    const sums: Array<string> = [];

    columns.forEach((col, index) => {
        if (index === 0) {
            sums[index] = "total";
        }

        const colName = col.property as string;

        if (NOT_SUMMARIZE_COLUMNS.includes(colName)) {
            return;
        }

        const values = data.map((item) => Number(item[colName as keyof InvoiceItem]));
        if (!values.every((value) => Number.isNaN(value))) {
            sums[index] = `${values.reduce((prev, curr) => {
                const value = Number(curr)
                if (!Number.isNaN(value)) {
                    return prev + curr
                } else {
                    return prev
                }
            }, 0)}`
        } else {
            sums[index] = '';
        }
    })

    return sums;
}

function updateAddItemModalVisible(newVal: boolean) {
    addItemModalVisible.value = newVal;

    if (!newVal) {
        editItem.value = undefined;
        addItemEditMode.value = false;
    }
}

const invoiceStore = useInvoiceStore();
const invoiceItems = ref(invoiceStore.invoiceItems)

const deleteRow = (id: string) => {
    invoiceStore.removeInvoiceItem(id);

}

function updateInvoiceItems() {
    invoiceItems.value = invoiceStore.invoiceItems;
}

watch(() => invoiceStore.invoiceItems, updateInvoiceItems, { immediate: true });

const editItem = ref<InvoiceItem | undefined>(undefined);
const addItemEditMode = ref<boolean>(false);

const editRow = (id: string) => {
    console.log('%cwe are here', 'padding: 5px; background: hotpink; color: black;');
    const item = invoiceStore.getInvoiceById(id);
    console.log('%citem', 'padding: 5px; background: hotpink; color: black;', item);

    if (item) {
        editItem.value = item;
        addItemEditMode.value = true;
        addItemModalVisible.value = true;
    }
}



</script>