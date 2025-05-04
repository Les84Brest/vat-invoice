<template>
    <AppLayout>
        <InvoiceActions />
        <template v-if="isLoading">
            <div class="dashboard-container">
                <el-row :gutter="20">
                    <el-col :span="8">
                        <el-card class="dashboard-card">
                            <el-skeleton :rows="3" animated />
                        </el-card>
                    </el-col>
                    <el-col :span="8">
                        <el-card class="dashboard-card">
                            <el-skeleton :rows="3" animated />
                        </el-card>
                    </el-col>
                    <el-col :span="8">
                        <el-card class="dashboard-card">
                            <el-skeleton :rows="3" animated />
                        </el-card>
                    </el-col>
                </el-row>
            </div>
        </template>
        <div class="dashboard-container">
            <el-row :gutter="20">
                <el-col :span="8">
                    <el-card class="dashboard-card">
                        <template #header>
                            <div class="card-header">
                                <span>Создано ЭСЧФ</span>
                            </div>
                        </template>
                        <div class="card-content">
                            <div class="stat-number">{{ invoiceCount }}</div>
                            <div class="stat-description">Количество созданных ЭСЧФ</div>

                        </div>
                    </el-card>
                </el-col>

                <el-col :span="8">
                    <el-card class="dashboard-card">
                        <template #header>
                            <div class="card-header">
                                <span>Входящий НДС</span>
                            </div>
                        </template>
                        <div class="card-content">
                            <div class="stat-number">{{ formatCurrency(incomingVAT) }}</div>
                            <div class="stat-description">Суммы НДС, принятые к зачету.</div>

                        </div>
                    </el-card>
                </el-col>

                <el-col :span="8">
                    <el-card class="dashboard-card">
                        <template #header>
                            <div class="card-header">
                                <span>Исходящий НДС</span>
                            </div>
                        </template>
                        <div class="card-content">
                            <div class="stat-number">{{ formatCurrency(outgoingVAT) }}</div>
                            <div class="stat-description">Суммы НДС, выставленные контрагентам</div>
                        </div>
                    </el-card>
                </el-col>
            </el-row>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@layouts/AppLayout.vue";
import InvoiceActions from "@components/invoice/InvoiceActions.vue";
import { ref, onMounted } from "vue";
import { useAuthStore } from "@/store/auth";
import axios from "axios";

interface DashboardData {
    invoiceCount: number
    incomingVAT: number
    outgoingVAT: number
}


const invoiceCount = ref<number>(0);
const incomingVAT = ref<number>(0);
const outgoingVAT = ref<number>(0);

const isLoading = ref<boolean>(false);
const error = ref<string | null>(null)


const authStore = useAuthStore();


const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'BYN',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(value)
}

// const loadDashboardData = async () => {
//     // In a real app, you would fetch this from an API
//     isLoading.value = true;

//     try {
//         const response = await axios.get('/api/v1/dashboard-data');
//     } catch (error) {
//         console.log('%cerror', 'padding: 5px; background: DarkGreen; color: MediumSpringGreen;', error);
//     }
//     setTimeout(() => {
//         invoiceCount.value = 142;
//         incomingVAT.value = 8750.42;
//         outgoingVAT.value = 6420.18;
//         isLoading.value = false;
//     }, 1700)
// }

const loadDashboardData = async (): Promise<void> => {
    isLoading.value = true
    error.value = null

    try {
        const response = await axios.get<DashboardData>('/api/v1/dashboard-data')
        const data = response.data

        invoiceCount.value = data.invoiceCount
        incomingVAT.value = data.incomingVAT
        outgoingVAT.value = data.outgoingVAT
    } catch (err) {
        console.error('Не удалось загрузить данные для даборда:', err)
        error.value = 'Не удалось загрузить данные для даборда. Пожалуйста попробуйте позже.'
        // You might want to reset values or keep previous data
        invoiceCount.value = 0
        incomingVAT.value = 0
        outgoingVAT.value = 0
    } finally {
        isLoading.value = false
    }
}

onMounted(() => {
    loadDashboardData();
})
</script>
<style scoped>
.dashboard-container {
    padding: 20px;
}

.dashboard-card {
    margin-bottom: 20px;
    height: 180px;
}

.card-header {
    font-size: 18px;
    font-weight: 600;
    color: var(--el-text-color-primary);
}

.card-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 120px;
}

.stat-number {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 10px;
    color: var(--el-color-primary);
}

.stat-description {
    font-size: 14px;
    color: var(--el-text-color-secondary);
}
</style>