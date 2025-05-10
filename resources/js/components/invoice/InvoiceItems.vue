<template>
    <div class="invoice-items__actions">
        <el-button :icon="Plus" type="primary" @click="addItemModalVisible = true">Добавить
            позицию</el-button>
    </div>
    <el-table :data="invoiceItems" show-summary :summary-method="vatTableSummaries" sum-text="Всего" border style="width: 100%"
        empty-text="Добавьте данные">
        <el-table-column type="index" label="№ п/п" width="70" />
        <el-table-column prop="name" label=" Наименование товаров (работ, услуг), имущественных прав" width="200" />
        <el-table-column prop="dimension" label="Единица измерения" width="70" />
        <el-table-column prop="count" label="Количество (объем)" width="100" />
        <el-table-column prop="price"
            label="Цена (тариф) за единицу товара (работы, услуги), имущественных прав без учета НДС, руб.">
            <template #default="scope">
                {{ formatCurrency(scope.row.price) }}
            </template>
        </el-table-column>
        <el-table-column prop="cost" label="Стоимость товаров (работ, услуг), имущественных прав без учета НДС, руб.">
            <template #default="scope">
                {{ formatCurrency(scope.row.cost) }}
            </template>
        </el-table-column>
        <el-table-column prop="vat_rate" label="НДС ставка, %" width="100">
            <template #default="scope">
                {{ formatVatRate(scope.row.vat_rate) }}
            </template>
        </el-table-column>
        <el-table-column prop="vat_sum" label="НДС сумма, руб." >
            <template #default="scope">
                {{ formatCurrency(scope.row.vat_sum) }}
            </template>
            </el-table-column>
        <el-table-column prop="cost_vat" label=" Стоимость товаров (работ, услуг), имущественных прав с учетом НДС, руб." >
            <template #default="scope">
                {{ formatCurrency(scope.row.cost_vat) }}
            </template>
            </el-table-column>

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
import type { InvoiceItem } from '@/types/invoice';
import { formatCurrency, formatVatRate } from "@/utils/format";
import useVatTableSummaries from '@/composables/useVatTableSummaries';


const NOT_SUMMARIZE_COLUMNS = [
    'count',
    'dimension',
    'name',
    'price',
    'vat_rate'
];

const vatTableSummaries = useVatTableSummaries(NOT_SUMMARIZE_COLUMNS, 'Всего');
const addItemModalVisible = ref<boolean>(false);


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

<style  lang="scss">
.invoice-items {
    &__actions {
        margin-bottom: 16px;
    }
}
</style>