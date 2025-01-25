<template>
    <!-- <el-header class="app-header">
        <div class="app-header__content">
            <div class="app-header-info">
                <el-avatar>ПВ</el-avatar>
            </div>
        </div>
    </el-header> -->
    <el-header class="app-header">
        <el-page-header title="Назад">
          
            <template #content>
                <div class="d-flex justify-content-between align-items-center" style="width: 100%">
                    <span class="text-large font-600 mr-3"> Неподписанные счета-фактуры</span>
                    <div class="app-header-info">
                        <el-avatar>ПВ</el-avatar>
                    </div>
                </div>
            </template>

            <template #breadcrumb>
                <el-breadcrumb separator="/">
                    <el-breadcrumb-item :to="{ path: './page-header.html' }">
                        Главная
                    </el-breadcrumb-item>
                    <el-breadcrumb-item>
                        <a href="./page-header.html">route 1</a>
                    </el-breadcrumb-item>
                    <el-breadcrumb-item>Счета</el-breadcrumb-item>
                </el-breadcrumb>
            </template>
        </el-page-header>
    </el-header>
</template>

<script setup lang="ts">
</script>