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
                <template v-if="isItemVisible(InvoiceAlowedActions.PREVIEW_INCOME_INVOICE)">
                    <el-dropdown-item :icon="DocumentChecked" @click="onIncomeInvoicePreview">Просмотр</el-dropdown-item>
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
import { DocumentChecked, Edit, EditPen, Failed, More } from "@element-plus/icons-vue";


const props = defineProps<{
    invoiceId: number,
    alowedActions?: Array<InvoiceAlowedActions>,
}>();

function isItemVisible(action: InvoiceAlowedActions) {
    if (!props.alowedActions) {
        return true;
    }

    return props.alowedActions.includes(action);
}
const { previewInvoice, previewIncomeInvoice, editInvoice, submitInvoice, cancelInvoice } = useTableActions();

const onInvoicePreview = () => {
    previewInvoice(props.invoiceId);
}
const onIncomeInvoicePreview = () => {
    previewIncomeInvoice(props.invoiceId);
}

const onInvoiceEdit = () => {
    editInvoice(props.invoiceId);
}

const onInvoiceSubmit = () => {
    submitInvoice(props.invoiceId);
}

const onInvoiceCancel = () => {
    cancelInvoice(props.invoiceId);
}

</script>

