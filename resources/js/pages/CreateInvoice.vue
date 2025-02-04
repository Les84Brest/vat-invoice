<template>
    <AppLayout>
        <el-card>
            <!-- <el-form ref="createFormRef" :rules="rules" :model="loginData" label-position="left" label-width="auto" -->
            <el-form ref="createFormRef" :model="invoiceData" label-position="left" label-width="auto"
                require-asterisk-position="left">
                <el-form-item label="Номер ЭСЧФ" prop="number">
                    <el-input v-model="invoiceData.number" placeholder="example@bstu.by" />
                </el-form-item>
                <el-form-item label="Пароль" prop="password">
                    <el-input type="password" v-model="loginData.password" />
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="submitCreate(createFormRef)">
                        Создать
                    </el-button>
                </el-form-item>

            </el-form>
        </el-card>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@layouts/AppLayout.vue";
import { ref } from "vue";


const createFormRef = ref<FormInstance>();

const invoiceData = {
    number: '',
}
function submitCreate(ormEl: FormInstance | undefined) {

}


</script>