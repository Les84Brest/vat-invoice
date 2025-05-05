<template>
    <el-dialog v-model="confirmDialogVisible" title="Введите пароль" width="20%" center :before-close="handleBeforeClose">
        <el-form :model="confirmForm" :rules="rules" ref="confirmFormRef">
            <el-form-item>
                <el-input v-model="confirmForm.password" autocomplete="off" type="password" />
            </el-form-item>

        </el-form>
        <template #footer>
            <span class="dialog-footer">
                <el-button @click="closeConfirmDialog">Закрыть</el-button>
                <el-button type="primary" @click="submitPasswordConfirmation(confirmFormRef)">
                    Подписать
                </el-button>
            </span>
        </template>
    </el-dialog>
</template>
<script  setup lang="ts">
import { useInvoiceStore } from "@/store/invoice";
import { reactive, computed, ref } from "vue";
import type { ElForm, FormInstance, FormRules } from 'element-plus';
import axios from "axios";

const invoiceStore = useInvoiceStore();

const confirmFormRef = ref<InstanceType<typeof ElForm>>();

const confirmDialogVisible = computed(() => invoiceStore.isPasswordConfirmDialogVisible);
const rules = reactive<FormRules>({
    password: [{ 'required': true, message: "Укажте ваш пароль" }]
});

const confirmForm = reactive({
    password: '',
})

const emit = defineEmits<{
    (e: 'user-password-confirmed', payload: { isConfirmed: boolean }): void
    (e: 'user-password-confirmed-cansel', payload: { isConfirmed: boolean }): void
}>();

function closeConfirmDialog() {
    invoiceStore.togglePasswordConfirmVisible();
}

function submitPasswordConfirmation(formEl: FormInstance | undefined) {
    if (!formEl) return;
    formEl.validate((valid) => {
        if (valid) {

            axios.post('/api/v1/confirm-password', JSON.stringify({ password: confirmForm.password }), {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then((response) => {
                    if (response?.status == 200) {
                        formEl.resetFields();
                        emit('user-password-confirmed', { isConfirmed: true });
                        emit('user-password-confirmed-cansel', { isConfirmed: true });
                    }
                })
                .catch((error) => {
                    formEl.resetFields();
                    emit('user-password-confirmed', { isConfirmed: false });
                    emit('user-password-confirmed-cansel', { isConfirmed: false });
                })
        }
    });

    invoiceStore.togglePasswordConfirmVisible();
}

function handleBeforeClose(done: () => void) {
    resetConfirmForm();
}

function resetConfirmForm() {
    if (confirmFormRef) {
        confirmFormRef.value?.resetFields();
    }
}
</script>