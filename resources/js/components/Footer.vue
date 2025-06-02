<template>
    <el-footer class="app-footer">
        <div class="app-footer__content">
            <span>&copy; БрГТУ - Все права защищены - {{ year }}</span>
        </div>
    </el-footer>
</template>

<script setup lang="ts">
const currentDate = new Date();
const year = currentDate.getFullYear();
</script>