
<script setup lang="ts">
import Aside from "@/components/Aside.vue";
import Footer from "@/components/Footer.vue";
import Header from "@/components/Header.vue";
import PasswordConfirmDialog from "@/components/PasswordConfirmDialog.vue";
</script>

<template>
    <el-container>
        <Aside />
        <el-container direction="vertical"  class="layout-wrap">
            <Header />
            <el-main class="app-main">
                <slot></slot>
            </el-main>
            <Footer />
        </el-container>
        <PasswordConfirmDialog/>
    </el-container>

    
</template>
