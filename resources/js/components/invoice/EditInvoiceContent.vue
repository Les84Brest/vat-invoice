<template>
    <el-card>
        <h3>Счет номер {{ invoiceData.number }}</h3>
        <el-form ref="createFormRef" :model="invoiceData" label-position="left" label-width="auto" :rules="invoiceRules"
            require-asterisk-position="left">
            <el-divider content-position="left">Общие данные</el-divider>
            <el-row>
                <el-col :span=8>
                    <el-form-item label="Номер ЭСЧФ" prop="number">
                        <el-input v-model="invoiceData.number" placeholder="" />
                    </el-form-item>
                </el-col>

            </el-row>
            <el-row>
                <el-col :span=11>
                    <el-form-item label="Дата выставления ЭСЧФ" prop="creation_date">
                        <el-date-picker v-model="invoiceData.creation_date" type="date" placeholder="Выберите дату"
                            style="width: 100%" format="DD.MM.YYYY" value-format="YYYY-MM-DD" />
                    </el-form-item>
                </el-col>
                <el-col :span=2 class="text-center">

                </el-col>
                <el-col :span=11>
                    <el-form-item label="Дата совершения операции" prop="action_date">
                        <el-date-picker v-model="invoiceData.action_date" type="date" placeholder="Выберите дату"
                            style="width: 100%" format="DD.MM.YYYY" value-format="YYYY-MM-DD" />
                    </el-form-item>
                </el-col>
            </el-row>

            <el-row>
                <el-col :span=12>
                    <el-form-item label="Тип ЭСЧФ">
                        <el-radio-group v-model="invoiceData.type">
                            <el-radio value="ORIGINAL" checked>Исходный</el-radio>
                            <el-radio value="CORRECTED">Исправленный</el-radio>
                        </el-radio-group>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="К ЭСЧФ" prop="parent_invoice_id">
                <el-input v-model="invoiceData.parent_invoice_id" :disabled="parentInvoiceIdDisabled" />
            </el-form-item>
            <el-divider content-position="left">Реквизиты поставщика</el-divider>
            <el-row>
                <el-col :span=8><el-text>УНП:</el-text></el-col>
                <el-col :span=8><el-text>{{ company?.tax_id }}</el-text></el-col>
            </el-row>
            <el-row>
                <el-col :span=8><el-text>Поставщик:</el-text></el-col>
                <el-col :span=8><el-text>{{ company?.title }}</el-text></el-col>
            </el-row>
            <el-row>
                <el-col :span=8><el-text>Юридический адрес (адрес места жительства индивидуального
                        предпринимателя):</el-text></el-col>
                <el-col :span=8><el-text>{{ company?.address }}</el-text></el-col>
            </el-row>

            <el-divider content-position="left">Реквизиты получателя</el-divider>
            <el-form-item label="УНП" prop="receiverTaxId">
                <el-autocomplete v-model="invoiceData.receiverTaxId" :fetch-suggestions="fetchTaxIds"
                    popper-class="reciever-autocomplete" placeholder="Введите УНП" @select="handleSelectReceiverTaxId">
                    <template #suffix>
                        <el-icon class="el-input__icon">
                            <Edit />
                        </el-icon>
                    </template>
                    <template #default="{ item }">
                        <div class="tax-id">{{ item.value }}</div>
                        <div class="company-title">{{ item.title }}</div>
                    </template>
                </el-autocomplete>
            </el-form-item>
            <template v-if="invoiceReciever">
                <el-row>
                    <el-col :span=8>Получатель</el-col>
                    <el-col :span=8>
                        {{ invoiceReciever.title }}
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span=8>Юридический адрес (адрес места жительства индивидуального
                        предпринимателя)</el-col>
                    <el-col :span=8>
                        {{ invoiceReciever.address }}
                    </el-col>
                </el-row>
            </template>
            <el-divider content-position="left"> Условия поставки </el-divider>
            <el-text>
                Договор (контракт) напоставку товаров (выполнение работ, оказание услуг), передачу имущественных прав
            </el-text>
            <el-row>
                <el-col :span=11>
                    <el-form-item label="Номер" prop="contract_number">
                        <el-input v-model="invoiceData.contract_number" placeholder="" />
                    </el-form-item>
                </el-col>
                <el-col :span=2></el-col>
                <el-col :span=11>
                    <el-form-item label="Дата" prop="contract_date">
                        <el-date-picker v-model="invoiceData.contract_date" type="date" placeholder="Выберите дату"
                            style="width: 100%" format="DD.MM.YYYY" value-format="YYYY-MM-DD" />
                    </el-form-item>
                </el-col>
            </el-row>
            <DeliveryDocuments :docs="deliveryDocs" @update-delivery-documents="onUpdateDeliveryDocuments"
                ref="deliveryDocumentsRef" />
            <el-divider content-position="left">Данные по товарам (работам, услугам), имущественным правам </el-divider>

            <div class="invoice__items">
                <InvoiceItems />
            </div>

            <el-form-item>
                <el-button type="primary" @click="submitUpdate(createFormRef)">
                    Сохранить
                </el-button>
                <!-- <el-button @click="submitCreateAndSend(createFormRef)">
                    Сохранить и отправить
                </el-button> -->
            </el-form-item>

        </el-form>
    </el-card>

    <PasswordConfirmDialog @user-password-confirmed="handlePasswordConfirmed" />
</template>

<script setup lang="ts">
import { useAuthStore } from "@/store/auth";
import { Company } from "@/types/company";
import { DeliveryDocument, InvoiceStatus, InvoiceType, NewInvoice } from "@/types/invoice";
import { formatDateForDatePicker, getCurrentDate } from "@/utils/date";
import { addLeadingZeros } from "@/utils/format";
import DeliveryDocuments from "@components/invoice/DeliveryDocuments.vue";
import PasswordConfirmDialog from "./PasswordConfirmDialog.vue";
import InvoiceItems from "@components/invoice/InvoiceItems.vue";
import { Edit } from "@element-plus/icons-vue";
import axios from "axios";
import { ElNotification, FormInstance, FormRules } from "element-plus";
import type { ComponentPublicInstance } from 'vue';
import { computed, reactive, ref, watch, h } from "vue";
import { useInvoiceStore } from "@/store/invoice";
import { useRouter, useRoute } from "vue-router";
import { onMounted } from "vue";

interface CustomComponentPublicInstance extends ComponentPublicInstance {
    $on: (event: string, callback: (...args: any[]) => void) => void;
}


const authStore = useAuthStore();
const company = computed(() => authStore.user?.company);
const newInvoiceNumber = computed(() => authStore.newInvoiceNumber);
const createFormRef = ref<FormInstance>();
const invoiceStore = useInvoiceStore();
const isSubmitAndSendPressed = ref<boolean>(false);
const router = useRouter();
const route = useRoute();
const deliveryDocs = ref<DeliveryDocument[] | null>(null);

const invoiceData = reactive({
    number: addLeadingZeros(newInvoiceNumber.value, 9),
    creation_date: getCurrentDate(),
    action_date: '',
    type: InvoiceType.ORIGINAL,
    parent_invoice_id: null,
    contract_number: '',
    contract_date: '',
    receiverTaxId: '',
})

watch(newInvoiceNumber, (newValue) => {
    invoiceData.number = addLeadingZeros(newValue, 9);
}, { deep: true });

const parentInvoiceIdDisabled = computed(() => invoiceData.type === 'ORIGINAL');

const invoicePostfix = computed(() => {
    const curDate = new Date();
    const year = `-${curDate.getFullYear()}`;
    const taxId = authStore.user?.company.tax_id

    return `${year}-${taxId}`;
});

const invoiceReciever = ref<Company | null>(null);

async function fetchTaxIds(queryString: string, cb: (arg: any) => void) {
    try {
        const response = await axios.get('/api/v1/reciever_tax_ids', {
            params: {
                query: queryString
            }
        });

        cb(response.data.data);
    } catch (error) {
        console.error('Error fetching suggestions:', error);
        cb([]);
    }
}

async function handleSelectReceiverTaxId(item: Record<string, any>) {
    try {
        const response = await axios.get('/api/v1/reciever_company', {
            params: {
                tax_id: item.value
            }
        });
        invoiceReciever.value = response.data.data;
    } catch (error) {
        console.error('Ошибка при загрузке данных компании', error);
    }

}

// deliveryDocumets 
function onUpdateDeliveryDocuments(documents: Array<DeliveryDocument>) {
    deliveryDocuments.value = documents;
}
const deliveryDocuments = ref<Array<DeliveryDocument>>([]);
const deliveryDocumentsRef = ref<CustomComponentPublicInstance | null>(null);

// submit invoice
function submitUpdate(formEl: FormInstance | undefined) {
    if (!formEl) return;
    formEl.validate((valid) => {
        if (valid) {
            if (invoiceStore.invoiceItems.length == 0) {
                ElNotification({
                    title: 'Не хватает информации',
                    message: h('i', { style: 'color: teal' }, 'Заполните раздел "Данные по товарам (работам, услугам), имущественным правам"'),
                    type: 'error',
                })

                return;
            }

            const editInvoice = buildInvoiceData();
            const jsonData = JSON.stringify(editInvoice);

            axios.put(`/api/v1/invoice/${route.params.id}}`, jsonData, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            })
                .then((data) => {
                    ElNotification({
                        title: 'Счет обновлен',
                        type: "success",
                    });
                    isSubmitAndSendPressed.value = false;
                    invoiceStore.invoiceItems = [];

                    setTimeout(() => {
                        router.push('/vat');
                    }, 1600);
                });
        } else {
            console.log('error submit!')
        }
    })
}

//submit and send invoice
function submitCreateAndSend(formEl: FormInstance | undefined) {
    if (!formEl) return;

    formEl.validate((valid) => {
        if (valid) {
            // switch component in submit and send mode. 
            // @user-password-confirmed listener starts to work
            isSubmitAndSendPressed.value = true;
            invoiceStore.togglePasswordConfirmVisible();
        }
    });
}

function handlePasswordConfirmed(payload: { isConfirmed: boolean }) {
    if (!isSubmitAndSendPressed.value) {
        return;
    }

    const { isConfirmed } = payload;

    if (!isConfirmed) {
        ElNotification({
            title: 'Пароль не подтвержден',
            message: h('i', { style: 'color: teal' }, 'Неправильный пароль'),
            type: 'error',
        });
        isSubmitAndSendPressed.value = false;

        return;
    }

    const editInvoice = buildInvoiceData();
    const jsonData = JSON.stringify(editInvoice);

    axios.post('/api/v1/invoice/submit-and-store', jsonData, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then((data) => {
            ElNotification({
                title: 'Счет сохранен и подписан',
                message: h('i', { style: 'color: teal' }, "Счет  создан и отправлен получателю"),
                type: "success",
            });
            isSubmitAndSendPressed.value = false;

            setTimeout(() => {
                router.push('/vat');
            }, 2000);
        });
}

function buildInvoiceData(): NewInvoice | null {
    const senderCompanyId = authStore.user?.company.id;
    const authorId = authStore.user?.id;
    const recipientCompanyId = invoiceReciever.value?.id;

    if (senderCompanyId && authorId && recipientCompanyId) {

        const invoiceTotals = getInvoiceTotals();

        const invoice: NewInvoice = {
            number: invoiceData.number,
            creation_date: invoiceData.creation_date,
            action_date: invoiceData.action_date,
            type: invoiceData.type,
            status: InvoiceStatus.IN_PROGRESS,
            total_wo_vat: invoiceTotals.total_wo_vat,
            total_vat: invoiceTotals.total_vat,
            total: invoiceTotals.total,
            sender_company_id: senderCompanyId,
            author_id: authorId,
            recipient_company_id: recipientCompanyId,
            contract_number: invoiceData.contract_number,
            contract_date: invoiceData.contract_date,
            invoice_items: invoiceStore.invoiceItems,
        };
        const documents = deliveryDocuments.value;

        if (deliveryDocuments.value.length > 0) {
            invoice.delivery_documents = documents;
        }

        return invoice;
    }

    return null;

}

function getInvoiceTotals(): Record<string, number> {
    const invoiceTotals = {
        total_wo_vat: 0,
        total_vat: 0,
        total: 0,
    };
    if (!invoiceStore.invoiceItems.length) {
        return invoiceTotals;
    }

    invoiceStore.invoiceItems.forEach(item => {
        invoiceTotals.total_wo_vat += item.cost;
        invoiceTotals.total_vat += item.vat_sum;
        invoiceTotals.total += item.cost_vat;
    });
    return invoiceTotals;
}
// invoice validation
const invoiceRules = reactive<FormRules>({
    number: [{ 'required': true, message: "Укажите номер ЭСЧФ", trigger: 'blur' }],
    creation_date: [{ 'required': true, message: "Заполните дату выставления ЭСЧФ", trigger: 'blur' }],
    action_date: [
        { 'required': true, message: "Заполните дату совершения операции", trigger: 'change' },
        {
            validator: (rule, value, callback) => {
                if (!value) {
                    callback(new Error('Заполните дату совершения операции'));
                } else if (invoiceData.action_date && value >= invoiceData.creation_date) {
                    callback(new Error('Дата совршения операции должна быть раньше даты создания счета'));
                } else {
                    callback();
                }
            }, trigger: 'change'
        }
    ],
    receiverTaxId: [
        { 'required': true, message: "Выберите УНП получателя счета", trigger: 'blur' },
    ],
    contract_number: [
        { 'required': true, message: "Укажите номер договора", trigger: 'blur' },
    ],
    contract_date: [{ 'required': true, message: "Заполните дату договора", trigger: 'blur' },
    {

        validator: (rule, value, callback) => {
            if (!value) {
                callback(new Error('Заполните дату договора'));
            } else if (invoiceData.action_date && value >= invoiceData.creation_date) {
                callback(new Error('Дата договора должна быть раньше даты создания счета'));
            } else {
                callback();
            }
        }, trigger: 'change'
    }
    ],
});
async function getEditInvoiceData() {
    let editInvoice = null;

    if (invoiceStore.currentInvoice && invoiceStore.currentInvoice?.id === +route.params.id) {
        editInvoice = JSON.parse(JSON.stringify(invoiceStore.currentInvoice));
    } else {
        try {
            const response = await axios.get(`/api/v1/invoice/${route.params.id}`);
            editInvoice = response.data.data;
        } catch (error) {
            console.log('%cerror on fetching edited invoice', 'padding: 5px; background: DarkKhaki; color: Yellow;');
        }
    }

    //Обовляем поля формы редактирования
    invoiceData.number = editInvoice.number;
    invoiceData.creation_date = formatDateForDatePicker(editInvoice.creation_date);
    // invoiceData.action_date = editInvoice.action_date;
    invoiceData.action_date = formatDateForDatePicker(editInvoice.action_date);

    invoiceData.type = editInvoice.type;
    invoiceData.parent_invoice_id = null;
    invoiceData.contract_number = editInvoice.contract_number;
    invoiceData.contract_date = formatDateForDatePicker(editInvoice.contract_date);
    invoiceData.receiverTaxId = editInvoice.recipient_company.tax_id;


    //update delivery documents
    deliveryDocs.value = editInvoice.delivery_documents;
    invoiceStore.invoiceItems = editInvoice.invoice_items;
    console.log('%cedit invo', 'padding: 5px; background: hotpink; color: black;', editInvoice);

}


onMounted(async () => {
    await getEditInvoiceData();
});
</script>

<style lang="scss">
.reciever-autocomplete {
    li {
        line-height: normal;
        margin-bottom: 8px;
    }

    .company-title {
        font-size: 12px;
    }
}
</style>