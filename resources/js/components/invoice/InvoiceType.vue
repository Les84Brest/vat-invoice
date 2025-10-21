<template>
    <el-tag :type="tagType" disable-transitions>{{ typeText }}</el-tag>
</template>

<script setup lang="ts">
import { InvoiceType } from '@/types/invoice';
import { getTypeText } from '@/utils/invoice';
import { computed, ref } from 'vue';

const typeText = computed(() => getTypeText(props.type));

const tagType = computed(() => {

    const status = props.type;

    switch (status) {
        case InvoiceType.ORIGINAL:
            return "success";

        default: return "";
    }
});

const props = defineProps<
    {
        type: string,
    }
>();

</script>