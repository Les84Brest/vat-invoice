import { useRouter } from "vue-router";
import { useUiStore } from "@/store/ui";
import { watch, h } from "vue";
import { ConfirmPasswordStatus } from "@/types/ui";
import axios from "axios";
import { ElNotification } from "element-plus";
import { useInvoiceStore } from "@/store/invoice";

const SUBMIT_INVOICE_URL = "/api/v1/invoice/submit-invoice";
const CANCEL_INVOICE_URL = "/api/v1/invoice/cancel-invoice";

export default function useTableActions() {
    const router = useRouter();
    const uiStore = useUiStore();
    const invoiceStore = useInvoiceStore();

    const submitInvoice = (id: number) => {
        uiStore.togglePasswordConfirm();

        watch(
            () => uiStore.confirmationStatus,
            async (newStatus: ConfirmPasswordStatus) => {
                if (newStatus === ConfirmPasswordStatus.CONFIRMATION_SUCCESS) {
                    try {
                        const response = await axios.post(
                            SUBMIT_INVOICE_URL,
                            { id },
                            {
                                headers: {
                                    "Content-Type": "application/json",
                                },
                            }
                        );
                    } catch (error) {
                        ElNotification({
                            title: "Ошибка при подписании счета",
                            message: h("i", { style: "color: teal" }, ""),
                            type: "error",
                        });
                    }
                }
            }
        );
    };

    const cancelInvoice = (id: number) => {
        uiStore.togglePasswordConfirm();

        watch(
            () => uiStore.confirmationStatus,
            async (newStatus: ConfirmPasswordStatus) => {
                if (newStatus === ConfirmPasswordStatus.CONFIRMATION_SUCCESS) {
                    try {
                        const response = await axios.post(
                            CANCEL_INVOICE_URL,
                            { id },
                            {
                                headers: {
                                    "Content-Type": "application/json",
                                },
                            }
                        );
                        if (response.status == 200) {
                            ElNotification({
                                title: "Счет аннулирован",
                                message: h(
                                    "i",
                                    { style: "color: teal" },
                                    "Счет перемещен в разел Отправленные/Анулированые"
                                ),
                                type: "success",
                            });
                            setTimeout(() => {
                                invoiceStore.fetchSendInvoices();
                            }, 500);
                        }
                    } catch (error) {
                        ElNotification({
                            title: "Ошибка при аннулировании счета",
                            message: h("i", { style: "color: teal" }, ""),
                            type: "error",
                        });
                    }
                }
            }
        );
    };

    return {
        previewInvoice: (id: number) => router.push(`/vat/invoice/${id}`),
        previewIncomeInvoice: (id: number) =>
            router.push(`/vat/invoice-income/${id}`),
        editInvoice: (id: number) => router.push(`invoice/${id}/edit`),
        submitInvoice,
        cancelInvoice,
    };
}
