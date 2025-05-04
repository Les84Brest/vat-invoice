import { defineStore } from "pinia";
import { useAuthStore } from "./auth";
import {
    InvoiceItem,
    Invoice,
    toInvoiceType,
    toInvoiceStatus,
    InvoiceStatus,
} from "@/types/invoice";
import axios from "axios";

interface InvoiceState {
    invoiceItems: Array<InvoiceItem>;
    isPasswordConfirmDialogVisible: boolean;
    invoices: Array<Invoice>;
    currentInvoice?: Invoice | null;
    editedInvoice?: Invoice | null;
    totalInvoices?: number;
    pageCount?: number;
    fistPage?: number;
    lastPage?: number;
    currentPage: number;
}

export const useInvoiceStore = defineStore("invoice", {
    state: (): InvoiceState => {
        return {
            invoiceItems: [],
            isPasswordConfirmDialogVisible: false,
            invoices: [], //storage to list invoices
            totalInvoices: 0,
            pageCount: 0,
            fistPage: 0,
            lastPage: 0,
            currentPage: 0,
            currentInvoice: null,
            editedInvoice: null,
        };
    },
    actions: {
        // invoice items
        addInvoiceItem(item: InvoiceItem) {
            this.invoiceItems.push(item);
        },
        removeInvoiceItem(id: string) {
            const itemIndex = this.invoiceItems.findIndex(
                (item) => item.id === id
            );

            if (itemIndex >= 0) {
                this.invoiceItems.splice(itemIndex, 1);
            }
        },
        updateInvoiceItem(item: InvoiceItem) {
            const itemId = item.id;
            const itemIndex = this.invoiceItems.findIndex(
                (item) => item.id === itemId
            );

            if (itemIndex >= 0) {
                this.invoiceItems.splice(itemIndex, 1, item);
            }
        },

        //password confirm dialog
        togglePasswordConfirmVisible() {
            this.isPasswordConfirmDialogVisible =
                !this.isPasswordConfirmDialogVisible;
        },
        //current invoices
        async fetchCurrentInvoices(page: number = 0): Promise<Invoice[]> {
            const auth = useAuthStore();

            const companyId = auth.user?.company.id;
            if (!companyId) {
                await auth.fetchAuthUser();
            }

            try {
                const response = await axios.get("/api/v1/invoice", {
                    params: {
                        sender_company_id: [auth.user?.company.id],
                        status: [InvoiceStatus.IN_PROGRESS],
                        page,
                    },
                });

                this.invoices = response.data.data;
                const { meta } = response.data;

                this.totalInvoices = meta.total ?? 0;

                this.pageCount = meta.last_page ?? 0;
                this.lastPage = meta.last_page ?? 0;
                this.currentPage = meta.current_page ?? 0;

                return response.data.data;
            } catch (error) {
                console.error("Не удалось загрузить счета", error);
                throw error;
            }
        },

        //current invoices
        async fetchSendInvoices(page: number = 0): Promise<Invoice[]> {
            const auth = useAuthStore();

            const companyId = auth.user?.company.id;
            if (!companyId) {
                await auth.fetchAuthUser();
            }

            try {
                const response = await axios.get("/api/v1/invoice", {
                    params: {
                        sender_company_id: [auth.user?.company.id],
                        status: [
                            InvoiceStatus.COMPLETED,
                            InvoiceStatus.COMPLETED_SIGNED,
                        ],
                        page,
                    },
                });

                this.invoices = response.data.data;
                const { meta } = response.data;

                this.totalInvoices = meta.total ?? 0;

                this.pageCount = meta.last_page ?? 0;
                this.lastPage = meta.last_page ?? 0;
                this.currentPage = meta.current_page ?? 0;

                return response.data.data;
            } catch (error) {
                console.error("Не удалось загрузить счета", error);
                throw error;
            }
        },

        async fetchSendCanseledInvoices(page: number = 0): Promise<Invoice[]>{
            const auth = useAuthStore();

            const companyId = auth.user?.company.id;
            if (!companyId) {
                await auth.fetchAuthUser();
            }

            try {
                const response = await axios.get("/api/v1/invoice", {
                    params: {
                        sender_company_id: [auth.user?.company.id],
                        status: [
                            InvoiceStatus.CANCELLED,
                            InvoiceStatus.ON_AGREEMENT,
                        ],
                        page,
                    },
                });

                this.invoices = response.data.data;
                const { meta } = response.data;

                this.totalInvoices = meta.total ?? 0;

                this.pageCount = meta.last_page ?? 0;
                this.lastPage = meta.last_page ?? 0;
                this.currentPage = meta.current_page ?? 0;

                return response.data.data;
            } catch (error) {
                console.error("Не удалось загрузить счета", error);
                throw error;
            }
        },
        async fetchIncomeUnsignedInvoices(page: number = 0): Promise<Invoice[]>{
            const auth = useAuthStore();

            const companyId = auth.user?.company.id;
            if (!companyId) {
                await auth.fetchAuthUser();
            }

            try {
                const response = await axios.get("/api/v1/invoice", {
                    params: {
                        recipient_company_id: [auth.user?.company.id],
                        status: [
                            InvoiceStatus.COMPLETED,
                        ],
                        page,
                    },
                });

                this.invoices = response.data.data;
                const { meta } = response.data;

                this.totalInvoices = meta.total ?? 0;

                this.pageCount = meta.last_page ?? 0;
                this.lastPage = meta.last_page ?? 0;
                this.currentPage = meta.current_page ?? 0;

                return response.data.data;
            } catch (error) {
                console.error("Не удалось загрузить счета", error);
                throw error;
            }
        },
        async fetchInvoiceById(id: number) {
            try {
                const response = await axios.get(`/api/v1/invoice/${id}`);
                this.currentInvoice = response.data.data;
            } catch (error) {}
        },
        setEditInvoice(invoice: Invoice) {
            this.editedInvoice = invoice;
        },
        signInvoice(number: number) {},
        cancelInvoice(number: number) {},
    },
    getters: {
        getInvoiceById: (state) => {
            return (id: string) => {
                const itemIndex = state.invoiceItems.findIndex(
                    (item) => item.id === id
                );

                if (itemIndex !== -1) {
                    return state.invoiceItems[itemIndex];
                }

                return null;
            };
        },
    },
});
