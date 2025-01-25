
<script setup lang="ts">
import Header from "@/components/Header.vue";
import Aside from "@/components/Aside.vue";
import Footer from "@/components/Footer.vue";
import {
    Expand,
    ChatLineSquare,
    Opportunity,
    CoffeeCup,
} from "@element-plus/icons-vue"
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
    </el-container>

    <!-- <el-container>
        <div class="navigation">
            <div class="logo">
                <el-icon :size="20">
                    <InfoFilled />
                </el-icon>
                <span class="logo__name">Счета по НДС</span>
            </div>
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <el-icon :size="23">
                                <Expand />
                            </el-icon>
                        </span>
                        <span class="title"> Название бренда</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <span class="icon">
                                <el-icon :size="23">
                                    <CoffeeCup />
                                </el-icon>
                            </span>
                        </span>
                        <span class="title"> Дашборд</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <span class="icon">
                                <el-icon :size="23">
                                    <Opportunity />
                                </el-icon>
                            </span>
                        </span>
                        <span class="title"> Заказчики</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <span class="icon">
                                <el-icon :size="23">
                                    <ChatLineSquare />
                                </el-icon>
                            </span>
                        </span>
                        <span class="title"> Сообщения</span>
                    </a>
                </li>
            </ul>
        </div>
    </el-container> -->
</template>
