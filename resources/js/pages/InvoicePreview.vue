<template>
    <AppLayout>
        <el-card class="invoice-card">
            <!-- Основная информация о счете -->
            <template v-if="invoiceStore.currentInvoice">
                <div class="invoice-header">
                    <h2>Счет № {{ invoiceStore.currentInvoice.number }}</h2>
                    <div class="invoice-meta">
                        <div><strong>Дата выставления:</strong> {{ invoiceStore.currentInvoice.creation_date
                        }}</div>
                        <div><strong>Дата совершения:</strong> {{ invoiceStore.currentInvoice.action_date
                        }}</div>
                        <div><strong>Статус:</strong>
                            <InvoiceStatus :status="invoiceStore.currentInvoice.status" />
                        </div>
                        <div><strong>Тип счета:</strong>
                            <InvoiceType :type="invoiceStore.currentInvoice.type" />
                        </div>
                    </div>

                </div>
                <el-divider>
                    <h3>Реквизиты поставщика</h3>
                </el-divider>
                <div class="invoice-party">
                    <div><strong>УНП:</strong> {{ invoiceStore.currentInvoice.sender_company.tax_id }}</div>
                    <div><strong>Поставщик:</strong> {{ invoiceStore.currentInvoice.sender_company.title }}</div>
                    <div><strong>Адрес:</strong> {{ invoiceStore.currentInvoice.sender_company.address }}</div>
                </div>
                <el-divider>
                    <h3>Реквизиты Получателя</h3>
                </el-divider>
                <div class="invoice-party">
                    <div><strong>УНП:</strong> {{ invoiceStore.currentInvoice.recipient_company.tax_id }}</div>
                    <div><strong>Получатель:</strong> {{ invoiceStore.currentInvoice.recipient_company.title }}</div>
                    <div><strong>Адрес:</strong> {{ invoiceStore.currentInvoice.recipient_company.address }}</div>
                </div>
                <!-- Информация о договоре -->
                <el-divider>
                    <h3>Условия поставки</h3>
                </el-divider>
                <div class="invoice-contract">
                    <el-text type="info" class="label-text">Договор (контракт) на поставку товаров (выполнение работ,
                        оказание услуг), передачу
                        имущественных прав</el-text>
                    <div><strong>Номер договора:</strong> {{ invoiceStore.currentInvoice.contract_number }}</div>
                    <div><strong>Дата договора:</strong> {{ invoiceStore.currentInvoice.contract_date }}</div>
                </div>
                <el-text type="info" class="label-text">
                    Документы, подтверждающие поставку товаров (работ, услуг), имущественных прав
                </el-text>

                <el-table empty-text="Нет данных" :data="invoiceStore.currentInvoice.delivery_documents" border>
                    <el-table-column prop="document_type" label="Вид документа" width="250" />
                    <el-table-column prop="number" label="Серия, номер" width="250" />
                    <el-table-column prop="date" label="Дата" width="250" />
                </el-table>

                <!-- Позиции счета -->
                <el-divider>
                    <h3>Данные по товарам (работам, услугам), имущественным правам</h3>
                </el-divider>
                <el-table empty-text="Нет данных" :data="invoiceStore.currentInvoice.invoice_items" border
                    style="width: 100%" show-summary :summary-method="getTableSummaries" sum-text="Всего">
                    <el-table-column type="index" label="№ п/п" width="70" />
                    <el-table-column prop="name" label=" Наименование товаров (работ, услуг), имущественных прав"
                        width="200" />
                    <el-table-column prop="dimension" label="Единица измерения" width="70" />
                    <el-table-column prop="count" label="Количество (объем)" width="100" />
                    <el-table-column prop="price"
                        label="Цена (тариф) за единицу товара (работы, услуги), имущественных прав без учета НДС, руб.">
                        <template #default="scope">
                            {{ formatCurrency(scope.row.price) }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="cost"
                        label="Стоимость товаров (работ, услуг), имущественных прав без учета НДС, руб.">
                        <template #default="scope">
                            {{ formatCurrency(scope.row.cost) }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="vat_rate" label="НДС ставка, %" width="100">
                        <template #default="scope">
                            {{ formatVatRate(scope.row.vat_rate) }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="vat_sum" label="НДС сумма, руб.">
                        <template #default="scope">
                            {{ formatCurrency(scope.row.vat_sum) }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="cost_vat"
                        label=" Стоимость товаров (работ, услуг), имущественных прав с учетом НДС, руб.">
                        <template #default="scope">
                            {{ formatCurrency(scope.row.cost_vat) }}
                        </template>
                    </el-table-column>
                </el-table>

                <div class="invoice-card__buttons">
                    <ul>
                        <li>
                            <el-button @click="onSumbitInvoice" type="primary" :disabled="!isButtonEnabled">
                                Подписать
                            </el-button>
                        </li>
                        <li>
                            <el-button @click="onEditInvoice" :disabled="!isButtonEnabled">
                                Редактировать
                            </el-button>
                        </li>
                        <li>
                            <el-button @click="onCloseInvoice">
                                Закрыть
                            </el-button>
                        </li>
                    </ul>
                </div>
            </template>

        </el-card>
        <PasswordConfirmDialog @user-password-confirmed="handlePasswordConfirmed" />

    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ElCard, ElDivider, ElNotification, ElTable, ElTableColumn, ElTag } from 'element-plus'
import { InvoiceStatus as InvoiceStatusType } from '@/types/invoice';
import InvoiceStatus from '@/components/invoice/InvoiceStatus.vue';
import InvoiceType from '@/components/invoice/InvoiceType.vue';
import PasswordConfirmDialog from '@/components/invoice/PasswordConfirmDialog.vue';
import { useInvoiceStore } from '@/store/invoice';
import { onMounted, ref, h } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import type { InvoiceItem } from '@/types/invoice';
import type { TableColumnCtx } from 'element-plus'
import axios from 'axios';
import { computed } from 'vue';
import { formatVatRate, formatCurrency } from '@/utils/format';
import useVatTableSummaries from "@/composables/useVatTableSummaries";

const invoiceStore = useInvoiceStore();
const router = useRouter();
const route = useRoute();
const invoiceId = route.params.id;

const isButtonEnabled = computed(() => {
    return invoiceStore.currentInvoice?.status == InvoiceStatusType.IN_PROGRESS;
})


const NOT_SUMMARIZE_COLUMNS = [
    'count',
    'dimension',
    'name',
    'price',
    'vat_rate'
];

const getTableSummaries = useVatTableSummaries(NOT_SUMMARIZE_COLUMNS, "Всего");

onMounted(async () => {
    await invoiceStore.fetchInvoiceById(+invoiceId);
})

// invoice actions
const isSubmitButtonPressed = ref<boolean>(false);
function onSumbitInvoice() {
    isSubmitButtonPressed.value = true;
    invoiceStore.togglePasswordConfirmVisible();
}

function onCloseInvoice() {
    router.back();
}

function onEditInvoice() {
    router.push(`/vat/invoice/${invoiceId}/edit`);
}

function handlePasswordConfirmed(payload: { isConfirmed: boolean }) {
    if (!isSubmitButtonPressed.value) {
        return;
    }

    const { isConfirmed } = payload;

    if (!isConfirmed) {
        ElNotification({
            title: 'Пароль не подтвержден',
            message: h('i', { style: 'color: teal' }, 'Неправильный пароль'),
            type: 'error',
        });
        isSubmitButtonPressed.value = false;

        return;
    }

    axios.post('/api/v1/invoice/submit-invoice', { id: invoiceId }, {
        headers: {
            'Content-Type': 'application/json'
        }
    }).then((data) => {
        ElNotification({
            title: 'Счет подписан',
            message: h('i', { style: 'color: teal' }, "Счет подписан и отправлен получателю"),
            type: "success",
        });
        isSubmitButtonPressed.value = false;
        setTimeout(() => {
            router.back();
        }, 1500);

    });
}
</script>


<style scoped>
.invoice-card {
    max-width: 1350px;
    margin: 20px auto;
}

.invoice-card .el-divider h3 {
    font-size: 1rem;
}

.invoice-header {
    margin-bottom: 20px;
}

.invoice-meta {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-top: 15px;
}

.invoice-party {
    margin: 15px 0;
}

.invoice-contract {
    margin: 15px 0;
}

.invoice-total {
    margin-top: 20px;
    text-align: right;
}

.el-divider__text {
    font-size: 16px;
}

.invoice-card__buttons {
    margin-top: 24px;
}

.invoice-card__buttons ul {
    display: flex;
    gap: 16px;
}
</style>