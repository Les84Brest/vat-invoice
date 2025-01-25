<template>
    <AppLayout>
        <el-card >
            <p v-for="o in 500" :key="o" class="text item">{{ 'List item ' + o }}</p>
          </el-card>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@layouts/AppLayout.vue';
import { ref } from 'vue';
import { ArrowLeft } from "@element-plus/icons-vue";
const someStr = ref('hello world');




</script>