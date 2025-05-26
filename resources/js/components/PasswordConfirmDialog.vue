<template>
    <el-dialog v-model="uiStore.isPasswordConfirmDialogVisible" title="Введите пароль" width="20%" center
        :before-close="handleBeforeClose">
        <el-form :model="confirmForm" :rules="rules" ref="confirmFormRef">
            <el-form-item prop="password">
                <el-input v-model="confirmForm.password" autocomplete="off" type="password" />
            </el-form-item>
        </el-form>

        <template #footer>
            <span class="dialog-footer">
                <el-button @click="closeConfirmDialog">Закрыть</el-button>
                <el-button type="primary" @click="submitPasswordConfirmation(confirmFormRef)">
                    Подтвердить пароль
                </el-button>
            </span>
        </template>
    </el-dialog>
</template>
<script  setup lang="ts">
// This component shows modal with password confirmation dialog
// In case when password confirmation status is success it changes status in ui store in Pinia 
// to CONFIRMATION_SUCCESS. If confirmation status was Failed CONFIRMATION_FAILED will be set
// Some external component can watch this statuses and fire some logic on changing ui Pinia store

import { useInvoiceStore } from "@/store/invoice";
import { useUiStore } from "@/store/ui";
import { ConfirmPasswordStatus } from "@/types/ui";
import axios from "axios";
import type { ElForm, FormInstance, FormRules } from 'element-plus';
import { ElNotification } from "element-plus";
import { h, reactive, ref, watch } from "vue";

const uiStore = useUiStore();
const confirmDialogVisible = ref<boolean>(false);

watch(() => uiStore.isPasswordConfirmDialogVisible, (isPasswordConfirmDialogVisible: boolean) => {
    isPasswordConfirmDialogVisible
        ? onOpenConfirmationDialog()
        : confirmDialogVisible.value = false;

}, { immediate: true })

const invoiceStore = useInvoiceStore();

const confirmFormRef = ref<InstanceType<typeof ElForm>>();


const rules = reactive<FormRules>({
    password: [
        { 'required': true, message: "Укажте ваш пароль" },
        { 'min': 8, message: "Пароль не короче 8 символов" }
    ],
});

const onOpenConfirmationDialog = () => {
    confirmDialogVisible.value = true;
    uiStore.setConfirmPasswordStatus(ConfirmPasswordStatus.CONFIRMATION_NOT_ASKED);
};

const confirmForm = reactive({
    password: '',
})


function closeConfirmDialog() {
    uiStore.togglePasswordConfirm();
}

function submitPasswordConfirmation(formEl: FormInstance | undefined) {
    if (!formEl) return;

    formEl.validate((valid) => {
        if (valid) {
            uiStore.setConfirmPasswordStatus(ConfirmPasswordStatus.CONFIRMATION_PENDING);
            axios.post('/api/v1/confirm-password', JSON.stringify({ password: confirmForm.password }), {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then((response) => {
                    console.log('%cresp', 'padding: 5px; background: DarkKhaki; color: Yellow;', response);
                    if (response?.status == 200) {
                        formEl.resetFields();
                        uiStore.setConfirmPasswordStatus(ConfirmPasswordStatus.CONFIRMATION_SUCCESS);
                        uiStore.togglePasswordConfirm();
                    }
                })
                .catch((error) => {
                    uiStore.setConfirmPasswordStatus(ConfirmPasswordStatus.CONFIRMATION_FAILED);

                    ElNotification({
                        title: 'Пароль не подтвержден',
                        message: h('i', { style: 'color: coral' }, 'Вы ввели неправильный пароль'),
                        type: 'error',
                    })

                })
                .finally(() => {
                    formEl.resetFields();
                }
                )
        } else {
            uiStore.setConfirmPasswordStatus(ConfirmPasswordStatus.CONFIRMATION_FAILED);
        }
    });

    invoiceStore.togglePasswordConfirmVisible();
}

function handleBeforeClose(done: () => void) {
    resetConfirmForm();
    uiStore.togglePasswordConfirm();
}

function resetConfirmForm() {
    if (confirmFormRef) {
        confirmFormRef.value?.resetFields();
    }
}
</script>