<template>
    <el-dialog v-model="dialogVisible" title="Добавить товар, услугу" width="700" :before-close="handleBeforeClose">
        <el-form :model="addFormData" :rules="rules" ref="addItemRef" label-position="top" label-width="auto">
            <el-form-item label="Наименование товара, работы, услуги" prop="name">
                <el-input v-model="addFormData.name" autocomplete="off" />
            </el-form-item>
            <el-form-item label="Единица измерения" prop="dimension">
                <el-select v-model="addFormData.dimension" placeholder="Выберите единицу измерения">
                    <el-option label="штука" value="шт." />
                    <el-option label="метр" value="м." />
                    <el-option label="метр погонный" value="м.п." />
                    <el-option label="килограмм" value="кг." />
                    <el-option label="центнер" value="ц." />
                    <el-option label="тонна" value="тн." />
                    <el-option label="час" value="ч." />
                </el-select>
            </el-form-item>
            <el-form-item label="Количество" prop="count">
                <el-input v-model="addFormData.count" type="number" />
            </el-form-item>
            <el-form-item label="Цена без НДС, руб.коп." prop="price">
                <el-input v-model="addFormData.price" type="number" />
            </el-form-item>
            <el-form-item label="Стоимость без НДС, руб.коп." prop="cost">
                <el-input v-model="addFormData.cost" type="number" />
            </el-form-item>
            <el-form-item label="Ставка НДС, %" prop="vat_rate">
                <el-select v-model="addFormData.vat_rate" placeholder="Выберите ставку НДС">
                    <el-option label="20%" value="0.2" />
                    <el-option label="10%" value="0.1" />
                    <el-option label="0%" value="0" />
                    <el-option label="Без НДС" :value="RATE_NO_VAT" />
                </el-select>
            </el-form-item>
            <el-form-item label="Сумма НДС, руб.коп." prop="vat_sum">
                <el-input v-model="addFormData.vat_sum" type="number" />
            </el-form-item>
            <el-form-item label="Всего с НДС, руб.коп." prop="cost_vat">
                <el-input v-model="addFormData.cost_vat" type="number" />
            </el-form-item>
            <div class="dialog-footer">
                <el-button type="primary" @click="onSubmit(addItemRef)">
                    Добавить
                </el-button>
                <el-button @click="handleCloseModal">Закрыть</el-button>
            </div>
        </el-form>

    </el-dialog>
</template>

<script setup lang="ts">
import { reactive, ref, defineProps, watch, onMounted } from 'vue';
import { InvoiceItem } from '@/types/invoice';
import type { ElForm, FormInstance, FormRules } from 'element-plus';
import { uuid } from 'vue-uuid';
import { useInvoiceStore } from '@/store/invoice';

/**
 * Represents the label for the "No VAT" rate.
 * @constant {string}
 */
const RATE_NO_VAT = "Без НДС";

/**
 * Defines the shape of the form data for adding a new invoice item.
 * Excludes the `id` property since it will be generated dynamically.
 * @typedef {Object} AddFormData
 * @property {string} name - The name of the invoice item.
 * @property {number} amount - The amount of the invoice item.
 * @property {string} rate - The tax rate applied to the invoice item.
 */
type AddFormData = Omit<InvoiceItem, "id">;

const props = defineProps<
    {
        isVisible: boolean,
        item?: InvoiceItem,
        editMode?: boolean,
    }
>();

const invoiceStore = useInvoiceStore();
const dialogVisible = ref<boolean>(props.isVisible);

//add and save item
const addItemRef = ref<InstanceType<typeof ElForm>>();
const rules = reactive<FormRules>({
    name: [{ 'required': true, message: "Укажите название товара, работы, услуги" }],
    vat_rate: [{ 'required': true, message: "Укажите ставку НДС" }]
})


const addFormData = reactive<AddFormData>({
    name: '',
    dimension: '',
    count: 0.0,
    price: 0.00,
    cost: 0.00,
    vat_rate: '',
    vat_sum: 0.00,
    cost_vat: 0.00,
});


watch(() => props.item, (newItem) => {
    if (props.item) {
        Object.assign(addFormData, newItem);
    }
}, { immediate: true })

watch(() => {
    return [
        addFormData.count,
        addFormData.price,
        addFormData.cost,
        addFormData.vat_rate
    ];
}, updateFormInputsValues);

function updateFormInputsValues() {
    const cost = addFormData.count * addFormData.price;
    const rate = getVatRate();
    const vatSum = cost * rate;
    const costVat = cost + vatSum;

    addFormData.cost = +cost.toFixed(2);
    addFormData.vat_sum = +vatSum.toFixed(2);
    addFormData.cost_vat = +costVat.toFixed(2);
}

function getVatRate(): number {
    switch (addFormData.vat_rate) {
        case RATE_NO_VAT:
            return 0;
        default:
            return +addFormData.vat_rate;
    }
}

function onSubmit(formEl: FormInstance | undefined) {
    if (!formEl) return;

    formEl.validate((valid) => {
        if (valid) {
            props.editMode ? handleUpdateItem() : handleAddItem(formEl);

        }
    })
}

function handleUpdateItem() {
    const id = props?.item?.id;
    if (id) {
        const newInvoiceItem: InvoiceItem = { ...addFormData, id };
        invoiceStore.updateInvoiceItem(newInvoiceItem);

        handleCloseModal();
    }
}

function handleAddItem(formEl: FormInstance | undefined) {
    const id = uuid.v4();
    const newInvoiceItem: InvoiceItem = { ...addFormData, id };

    invoiceStore.addInvoiceItem(newInvoiceItem);

    formEl?.resetFields();
    handleCloseModal();
}

//close form
function handleCloseModal() {
    resetAddItemForm();
    dialogVisible.value = false;
}
const handleBeforeClose = (done: () => void) => {
    resetAddItemForm();
    done();
};

const resetAddItemForm = () => {
    if (addItemRef.value) {
        addItemRef.value.resetFields();
    }
};

watch(
    () => props.isVisible,
    (newVal) => {
        dialogVisible.value = newVal;
    }
);

const emit = defineEmits(['update-isVisible']);

watch(dialogVisible, (newVal) => {
    emit('update-isVisible', newVal);
});
</script>