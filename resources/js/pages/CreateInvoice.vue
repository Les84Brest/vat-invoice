<template>
    <AppLayout>
        <el-card>
            <!-- <el-form ref="createFormRef" :rules="rules" :model="loginData" label-position="left" label-width="auto" -->
            <h3>Новый счет</h3>
            <el-form ref="createFormRef" :model="invoiceData" label-position="left" label-width="auto"
                require-asterisk-position="left">
                <el-divider content-position="left">Общие данные</el-divider>
                <el-row>
                    <el-col span="8">
                        <el-form-item label="Номер ЭСЧФ" prop="number">
                            <el-input v-model="invoiceData.number" placeholder="" />
                        </el-form-item>
                    </el-col>
                    <el-col span="10">
                        <div class="nvoice-postfix" style="margin-left: 1rem">
                            {{ invoicePostfix }}
                        </div>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="11">
                        <el-form-item label="Дата выставления ЭСЧФ" prop="creation_date">
                            <el-date-picker v-model="invoiceData.creation_date" type="date" placeholder="Выберите дату"
                                style="width: 100%" />
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" class="text-center">

                    </el-col>
                    <el-col :span="11">
                        <el-form-item label="Дата совершения операции" prop="action_date">
                            <el-date-picker v-model="invoiceData.action_date" type="date" placeholder="Выберите дату"
                                style="width: 100%" />
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-row>
                    <el-col span="12">
                        <el-form-item label="Тип ЭСЧФ">
                            <el-radio-group v-model="invoiceData.type">
                                <el-radio value="ORIGINAL">Исходный</el-radio>
                                <el-radio value="CORRECTED">Исправленный</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-form-item label="К ЭСЧФ" prop="parent_invoice_id">
                    <el-input v-model="invoiceData.parent_invoice_id" />
                </el-form-item>
                <el-divider content-position="left">Реквизиты поставщика</el-divider>
                <el-row>
                    <el-col :span="8"><el-text>УНП:</el-text></el-col>
                    <el-col :span="8"><el-text>{{ company?.tax_id }}</el-text></el-col>
                </el-row>
                <el-row>
                    <el-col :span="8"><el-text>Поставщик:</el-text></el-col>
                    <el-col :span="8"><el-text>{{ company?.title }}</el-text></el-col>
                </el-row>
                <el-row>
                    <el-col :span="8"><el-text>Юридический адрес (адрес места жительства индивидуального
                            предпринимателя):</el-text></el-col>
                    <el-col :span="8"><el-text>{{ company?.address }}</el-text></el-col>
                </el-row>

                <el-divider content-position="left">Реквизиты получателя</el-divider>
                <el-form-item label="УНП" prop="parent_invoice_id">
                    <el-autocomplete v-model="receiverTaxId" :fetch-suggestions="fetchTaxIds"
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
                        <el-col :span="8">Получатель</el-col>
                        <el-col :span="8">
                            {{ invoiceReciever.title }}
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="8">Юридический адрес (адрес места жительства индивидуального
                            предпринимателя)</el-col>
                        <el-col :span="8">
                            {{ invoiceReciever.address }}
                        </el-col>
                    </el-row>
                </template>
                <el-divider content-position="left"> Условия поставки </el-divider>
                <el-text>
                    Договор (контракт) напоставку товаров (выполнение работ, оказание услуг), передачу имущественных прав
                </el-text>
                <el-row>
                    <el-col :span="11">
                        <el-form-item label="Номер" prop="contract_number">
                            <el-input v-model="invoiceData.contract_number" placeholder="" />
                        </el-form-item>
                    </el-col>
                    <el-col :span="2"></el-col>
                    <el-col :span="11">
                        <el-form-item label="Дата" prop="contract_date">
                            <el-date-picker v-model="invoiceData.contract_date" type="date" placeholder="Выберите дату"
                                style="width: 100%" />
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-divider content-position="left">Данные по товарам (работам, услугам), имущественным правам </el-divider>

                <div class="invoice__items">
                    <InvoiceItems />
                </div>

                <el-form-item>
                    <el-button type="primary" @click="submitCreate(createFormRef)">
                        Создать
                    </el-button>
                    <el-button @click="submitCreate(createFormRef)">
                        Создать и подписать
                    </el-button>
                </el-form-item>

            </el-form>
        </el-card>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@layouts/AppLayout.vue";
import { FormInstance } from "element-plus";
import { reactive, computed, ref, onMounted } from "vue";
import { useAuthStore } from "@/store/auth";
import InvoiceItems from "@/components/InvoiceItems.vue";
import { Edit } from "@element-plus/icons-vue";
import axios from "axios";
import { Company } from "@/types/company";

const authStore = useAuthStore();

const company = computed(() => authStore.user?.company);


const createFormRef = ref<FormInstance>();

const invoiceData = reactive({
    number: '',
    creation_date: new Date(),
    action_date: '',
    type: '',
    parent_invoice_id: null,
    contract_number: '',
    contract_date: '',
})
function submitCreate(ormEl: FormInstance | undefined) {

}

const lastCompanyInvoiceNumber = ref(0);
const getInitialInvoiceData = async () => {
    const companyId = company.value?.id;

    const response = await axios.get('/api/v1/create_invoice_data', {
        params: {
            company: companyId
        }
    })
}
onMounted(async () => {
    await getInitialInvoiceData();
})
const invoicePostfix = computed(() => {

    const curDate = new Date();
    const year = `- ${curDate.getFullYear()}`;

    return year;

});




//autocomplete
interface TaxIdItem {
    id: number
    value: string
    title: string
}
const receiverTaxId = ref('');
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