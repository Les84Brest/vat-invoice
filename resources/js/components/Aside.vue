<template>
    <el-aside class="app-aside">
        <div class="app-logo">
            <a href="#" class="app-logo__link">
                <img src="@assets/images/vat-invoice-logo-light.svg" alt="Логотип приложения">
                <span class="app-logo__text">Счета по НДС</span>
            </a>
            <el-button :icon="DArrowLeft" class="toggle-menu" @click="handleToggleMenu"></el-button>
        </div>
        <el-scrollbar>
            <el-menu mode="vertical" router class="app-aside__menu menu-aside">

                <el-sub-menu index="100500">
                    <template #title>
                        <el-icon>
                            <DocumentCopy />
                        </el-icon>
                        <span>Мои счета-фактуры</span>
                    </template>

                    <el-menu-item index="1-1">
                        <el-icon>
                            <Compass />
                        </el-icon>
                        В работе (черновики)
                    </el-menu-item>
                 
                    <el-sub-menu index="1-1wewewewe">
                        <template #title>
                            <el-icon>
                                <MessageBox />
                            </el-icon>
                            <span>Входящие</span>
                        </template>
                        <el-menu-item index="1-1wqwqwqwqw">
                            Неподписанные
                        </el-menu-item>
                        <el-menu-item index="1-1sign">
                            Подписанные
                        </el-menu-item>
                        <el-menu-item index="1-1wqwqwqwqw">
                            Аннулированные
                        </el-menu-item>
                    </el-sub-menu>

                    <el-sub-menu index="1-send">
                        <template #title>
                            <el-icon>
                                <Finished/>
                            </el-icon>
                            <span>Отправеленные</span>
                        </template>

                        <el-menu-item index="1-1-send-sign">
                            Подписанные
                        </el-menu-item>
                        <el-menu-item index="1-1-send-fyek">
                            Аннулированные
                        </el-menu-item>
                    </el-sub-menu>




                </el-sub-menu>
                <el-menu-item index="1" route="welcome/login">
                    <el-icon>
                        <DataAnalysis />
                    </el-icon>
                    <span>Предварительный контроль</span>
                </el-menu-item>
            </el-menu>

        </el-scrollbar>
    </el-aside>
</template>


<script setup lang="ts">
import {
    DArrowLeft,
    DataAnalysis,
    Finished,
    Compass,
    MessageBox,
    DocumentCopy
} from "@element-plus/icons-vue";

function handleToggleMenu() {

    console.log('%chandle toggle menu', 'padding: 5px; background: hotpink; color: black;');
}
</script>