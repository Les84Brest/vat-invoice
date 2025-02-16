<template>
    <el-table :data="invoiceItems" show-summary sum-text="Всего" border style="width: 100%" empty-text="Добавьте данные">
        <el-table-column prop="row" label="№ п/п" width="70" />
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

                <el-button type="primary" :icon="Edit" circle @click.prevent="editRow(scope.$index)" />
                <el-button type="danger" :icon="Delete" circle @click.prevent="deleteRow(scope.$index)" />

            </template>
        </el-table-column>
    </el-table>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import { Delete, Edit } from '@element-plus/icons-vue';

const invoiceItems = ref([
    {
        row: 1,
        name: 'Шуруповерт ударный',
        dimension: 'шт',
        count: 2,
        price: 50.55,
        cost: 101.10,
        vat_rate: '20%',
        vat_sum: 20.22,
        cost_vat: 121.32,
    },
    {
        row: 2,
        name: 'Плита газовая ПГ3200-800',
        dimension: 'шт',
        count: 13,
        price: 350.20,
        cost: 4552.60,
        vat_rate: '20%',
        vat_sum: 910.52,
        cost_vat: 5463.12,
    },
    {
        row: 3,
        name: 'Плита электрическая ПЭ6100-20',
        dimension: 'шт',
        count: 7,
        price: 370.80,
        cost: 2595.60,
        vat_rate: '20%',
        vat_sum: 519.12,
        cost_vat: 3114.72,
    }
]);

const deleteRow = (index: number) => {
    invoiceItems.value.splice(index, 1)
}
const editRow = (index: number) => {
    console.log('%cстрока', 'padding: 5px; background: hotpink; color: black;', index);
}

</script>