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
            <el-menu mode="vertical" router  :default-active="$route.path" class="app-aside__menu menu-aside"  >

                <el-sub-menu index="my-invoices">
                    <template #title>
                        <el-icon>
                            <DocumentCopy />
                        </el-icon>
                        <span>Мои счета-фактуры</span>
                    </template>

                    <el-menu-item index="/vat/current" route="/vat/current">
                        <el-icon>
                            <Compass />
                        </el-icon>
                        В работе (черновики)
                    </el-menu-item>

                    <el-sub-menu index="income-invoices">
                        <template #title>
                            <el-icon>
                                <MessageBox />
                            </el-icon>
                            <span>Входящие</span>
                        </template>
                        <el-menu-item index="/vat/income/unsigned" route="/vat/income/unsigned">
                            Неподписанные
                        </el-menu-item>
                        <el-menu-item index="/vat/income/signed" route="/vat/income/signed">
                            Подписанные
                        </el-menu-item>
                        <el-menu-item index="/vat/income/canseled" route="/vat/income/canseled">
                            Аннулированные
                        </el-menu-item>
                    </el-sub-menu>

                    <el-sub-menu index="sent-invoices">
                        <template #title>
                            <el-icon>
                                <Finished />
                            </el-icon>
                            <span>Отправеленные</span>
                        </template>

                        <el-menu-item index="/vat/send/signed" route="/vat/send/signed">
                            Подписанные
                        </el-menu-item>
                        <el-menu-item index="/vat/send/canseled" route="/vat/send/canseled">
                            Аннулированные
                        </el-menu-item>
                    </el-sub-menu>




                </el-sub-menu>
                <el-menu-item index="/vat/control" route="/vat/control">
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

</script>