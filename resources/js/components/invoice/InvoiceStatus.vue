<template>
    <el-tag :type="tagType" disable-transitions>{{ statusText }}</el-tag>
</template>

<script setup lang="ts">
import { InvoiceStatus } from '@/types/invoice';
import { computed, ref } from 'vue';

const statusText = computed(() => getStatusText(props.status));

const tagType = computed(() => {

    const status = props.status;

    switch (status) {
        case InvoiceStatus.IN_PROGRESS:
            return "info";
        case InvoiceStatus.IN_PROGRESS_ERROR:
            return "danger";
        case InvoiceStatus.ON_AGREEMENT:
            return 'info'
        case InvoiceStatus.COMPLETED_SIGNED:
            return "success";
        case InvoiceStatus.COMPLETED:
            return 'warning'
        case InvoiceStatus.ON_AGREEMENT_CANCEL:
            return "";
        case InvoiceStatus.CANCELLED:
        default: return "success";
    }
});

const props = defineProps<
    {
        status: string,
    }
>();

function getStatusText(status: string): string {
    switch (status) {
        case InvoiceStatus.IN_PROGRESS:
            return "В разработке";
        case InvoiceStatus.IN_PROGRESS_ERROR:
            return "Ошибка";
        case InvoiceStatus.ON_AGREEMENT:
            return 'На согласовании'
        case InvoiceStatus.COMPLETED_SIGNED:
            return "Выставлен. Подписан получателем";
        case InvoiceStatus.COMPLETED:
            return 'Выставлен'
        case InvoiceStatus.ON_AGREEMENT_CANCEL:
            return "Выставлен. Аннулирован поставщиком";
        case InvoiceStatus.CANCELLED:
        default: return "";
    }
}


</script>