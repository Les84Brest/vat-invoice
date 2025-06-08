import { useRouter } from "vue-router";
import { useUiStore } from "@/store/ui";
import { watch, h } from "vue";
import { ConfirmPasswordStatus } from "@/types/ui";
import axios from "axios";
import { ElNotification } from "element-plus";
import { useInvoiceStore } from "@/store/invoice";
import { InvoiceStatus } from "@/types/invoice";

const SUBMIT_INVOICE_URL = "/api/v1/invoice/submit-invoice";
const CANCEL_INVOICE_URL = "/api/v1/invoice/cancel-invoice";

export default function useTableActions() {
    const router = useRouter();
    const uiStore = useUiStore();
    const invoiceStore = useInvoiceStore();
    const fetchInvoicesMap: Record<string, () => void> = {
        fetchCurrentInvoices: () => {
            invoiceStore.fetchCurrentInvoices();
        },
        fetchSendInvoices: () => {
            invoiceStore.fetchSendInvoices();
        },
        fetchSendCanseledInvoices: () => {
            invoiceStore.fetchSendCanseledInvoices();
        },
    };

    const isCancelConfirmationStatusEnabled = (id: number): boolean => {
        const [currentInvoice] = invoiceStore.invoices.filter(
            (item) => item.id === id
        );

        return currentInvoice.status === InvoiceStatus.ON_AGREEMENT_CANCEL;
    };

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

                        if (response.status == 200) {
                            ElNotification({
                                title: "Счет подписан",
                                message: h(
                                    "i",
                                    { style: "color: teal" },
                                    "Счет перемещен в разел Отправленные/Подписанные"
                                ),
                                type: "success",
                            });
                            const fetchFunction =
                                fetchInvoicesMap[
                                    invoiceStore.currentFetchFunctionName
                                ];

                            setTimeout(() => {
                                fetchFunction();
                            }, 500);
                        }
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
                                    "Счет перемещен в разел Отправленные/Аннулированые"
                                ),
                                type: "success",
                            });
                            const fetchFunction =
                                fetchInvoicesMap[
                                    invoiceStore.currentFetchFunctionName
                                ];

                            setTimeout(() => {
                                fetchFunction();
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

    const confirmInvoiceCancelConfirmation = (id: number) => {
        uiStore.togglePasswordConfirm();
    };

    return {
        previewInvoice: (id: number) => router.push(`/vat/invoice/${id}`),
        previewInvcomeInvoice: (id: number) =>
            router.push(`/vat/invoice-income/${id}`),
        previewIncomeInvoice: (id: number) =>
            router.push(`/vat/invoice-income/${id}`),
        editInvoice: (id: number) => router.push(`invoice/${id}/edit`),
        submitInvoice,
        cancelInvoice,
        confirmInvoiceCancelConfirmation,
        isCancelConfirmationStatusEnabled,
    };
}
