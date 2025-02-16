<template>
    <el-text> Документы, подтверждающие поставку товаров (работ, услуг), имущественных прав</el-text>
    <div class="delivery-documents__list">
        <ol class="list-documents">
            <li class="list-ducuments__item" v-for="document in deliveryDocuments" :key="document.id">
                <el-row :gutter="20">
                    <el-col :span="4">
                        <div class="list-documents__content">
                            <el-text>{{ document.document_type }}</el-text>
                        </div>
                    </el-col>
                    <el-col :span="2">
                        <div class="list-documents__content">
                            <el-text>{{ document.number }}</el-text>
                        </div>
                    </el-col>
                    <el-col :span="2">
                        <div class="list-documents__content">
                            <el-text>{{ formatDate(document.date) }}</el-text>
                        </div>
                    </el-col>
                    <el-col :span="1">
                        <div class="list-documents__content">
                            <el-button type="primary" :icon="Minus" @click="deleteDocument(document.id)" circle></el-button>
                        </div>
                    </el-col>
                </el-row>
            </li>
        </ol>
    </div>
    <div class="delivery-documents__add add-document" v-if="isAddMode">
        <el-form :model="addForm" :inline="true" ref="formRef" :rules="rules">
            <el-form-item label="Тип документа" prop="document_type">
                <el-select v-model="addForm.document_type" placeholder="Выберите тип" size="large" style="width: 240px">
                    <el-option value="ТН-1" label="Товарная накладная ТН-1" />
                    <el-option value="ТТН-2" label="Товарно-транспортная накладная ТТН-2" />
                    <el-option value="Акт" label="Акт выполненных работ" />
                </el-select>
            </el-form-item>
            <el-form-item label="Серия и номер документа" prop="number">
                <el-input v-model="addForm.number" />
            </el-form-item>
            <el-form-item label="Дата документа" prop="date">
                <el-date-picker v-model="addForm.date" type="date" placeholder="Выберите дату" style="width: 100%"
                    format="DD.MM.YYYY" value-format="YYYY-MM-DD" />
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit(formRef)">Сохранить</el-button>
            </el-form-item>
        </el-form>
    </div>
    <div class="delivery-documents__actions">
        <el-button type="primary" :icon="Plus" @click="toggleAddMode" :disabled="isAddMode">Добавить документ</el-button>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import type { DeliveryDocument } from "@/types/invoice";
import { Plus, Minus } from "@element-plus/icons-vue";
import type { FormInstance, FormRules } from 'element-plus';
import { uuid } from 'vue-uuid';
import { formatDate } from "@/utils/date";

const isAddMode = ref<boolean>(false);
const deliveryDocuments = reactive<Array<DeliveryDocument>>([]);
const formRef = ref<FormInstance>();

// const emit = defineEmits(['update-delivery-documents']);
const emit = defineEmits<{
    (e: 'update-delivery-documents', documents: Array<DeliveryDocument>): void
}>()

function toggleAddMode() {
    isAddMode.value = !isAddMode.value;
}



//submit document form
function onSubmit(formEl: FormInstance | undefined) {
    if (!formEl) return;

    formEl.validate((valid) => {
        if (valid) {
            const id = uuid.v4();
            const newDoc = { ...addForm, id };
            deliveryDocuments.push(newDoc);

            emit('update-delivery-documents', deliveryDocuments);

            formEl.resetFields();
            toggleAddMode();
        }
    })
}

function deleteDocument(id: string) {
    const index = deliveryDocuments.findIndex(doc => doc.id === id);
    if (index !== -1) {
        deliveryDocuments.splice(index, 1);
    }
}

//validation
interface IAddDocument {
    document_type: string,
    number: string,
    date: string,
}

const rules = reactive<FormRules<IAddDocument>>(
    {
        document_type: [{ 'required': true, message: "Заполните тип документа", trigger: 'blur' }],
        number: [{ 'required': true, message: "Заполните серию и номер документа", trigger: 'blur' }],
        date: [{
            type: 'date',
            required: true,
            message: 'Заполните дату документа',
            trigger: 'change',
        },],
    }
)

const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields();
}

//add document

const addForm = reactive<IAddDocument>({
    document_type: '',
    number: '',
    date: '',
});
</script>

<style scoped>
ol.list-documents {
    list-style: decimal;
}

.list-ducuments__item {
    margin-bottom: 10px;
}

.list-documents__content {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    height: 100%;
}
</style>