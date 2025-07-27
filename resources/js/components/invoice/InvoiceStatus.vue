<template>
    <el-tag :type="tagType" disable-transitions>{{ statusText }}</el-tag>
</template>

<script setup lang="ts">
import { InvoiceStatus } from '@/types/invoice';
import { getStatusText } from '@/utils/invoice';
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
            return "danger";
        case InvoiceStatus.CANCELLED:
            return "danger";
        default: return "success";
    }
});

const props = defineProps<
    {
        status: string,
    }
>();

</script>