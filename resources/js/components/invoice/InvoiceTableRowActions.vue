<template>
    <el-dropdown trigger="click">
        <span class="el-dropdown-link">
            <el-button :icon="More" />
        </span>
        <template #dropdown>
            <el-dropdown-menu trigger="click">

                <el-dropdown-item :icon="More" @click="onInvoicePreview">Просмотр</el-dropdown-item>
                <template v-if="isItemVisible(InvoiceAlowedActions.EDIT_INVOICE)">
                    <el-dropdown-item :icon="EditPen" divided @click="onInvoiceEdit">Редактировать</el-dropdown-item>
                </template>
                <el-dropdown-item :icon="Select" divided @click="onInvoiceSubmit">
                    Подписать</el-dropdown-item>
                <el-dropdown-item :icon="Failed" divided @click="onInvoiceCancel">
                    Анулировать</el-dropdown-item>

            </el-dropdown-menu>
        </template>
    </el-dropdown>
</template>

<script setup lang="ts">
import useTableActions from '@/composables/useTableActions';
import { InvoiceAlowedActions } from '@/types/invoiceTable';
import { More, EditPen, Failed, Select, } from "@element-plus/icons-vue"

const props = defineProps<{
    invoiceId: number,
    alowedActions?: Array<InvoiceAlowedActions>
}>();

function isItemVisible(action: InvoiceAlowedActions) {
    if (!props.alowedActions) {
        return true;
    }

    return props.alowedActions.includes(action);
}
const { previewInvoice, editInvoice, previewIncomeInvoice } = useTableActions();

const onInvoicePreview = () => {
    previewInvoice(props.invoiceId);
}

const onInvoiceEdit = () => {
    editInvoice(props.invoiceId);
}

const onInvoiceSubmit = () => {
    console.log('%cподписать счет', 'padding: 5px; background: crimson; color: white;');
}

const onInvoiceCancel = () => {
    console.log('%cаннулировать счет', 'padding: 5px; background: DarkKhaki; color: Yellow;');
}

</script>

