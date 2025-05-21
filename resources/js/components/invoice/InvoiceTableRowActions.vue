<template>
    <el-dropdown trigger="click">
        <span class="el-dropdown-link">
            <el-button :icon="More" />
        </span>
        <template #dropdown>
            <el-dropdown-menu trigger="click">
                <template v-if="isItemVisible(InvoiceAlowedActions.PREVIEW_INVOICE)">
                    <el-dropdown-item :icon="DocumentChecked" @click="onInvoicePreview">Просмотр</el-dropdown-item>
                </template>
                <template v-if="isItemVisible(InvoiceAlowedActions.EDIT_INVOICE)">
                    <el-dropdown-item :icon="EditPen" divided @click="onInvoiceEdit">Редактировать</el-dropdown-item>
                </template>
                <template v-if="isItemVisible(InvoiceAlowedActions.SIGN_INVOICE)">
                    <el-dropdown-item :icon="Edit" divided @click="onInvoiceSubmit">
                        Подписать</el-dropdown-item>
                </template>
                <template v-if="isItemVisible(InvoiceAlowedActions.CANCEL_INVOICE)">
                    <el-dropdown-item :icon="Failed" divided @click="onInvoiceCancel">
                        Аннулировать</el-dropdown-item>
                </template>

            </el-dropdown-menu>
        </template>
    </el-dropdown>
</template>

<script setup lang="ts">
import useTableActions from '@/composables/useTableActions';
import { InvoiceAlowedActions } from '@/types/invoiceTable';
import { More, EditPen, Failed,  DocumentChecked, Edit } from "@element-plus/icons-vue"

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

