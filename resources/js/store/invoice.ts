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
    invoicesPagination?: Record<string, string | number>
}

export const useInvoiceStore = defineStore("invoice", {
    state: (): InvoiceState => {
        return {
            invoiceItems: [],
            isPasswordConfirmDialogVisible: false,
            invoices: [], //storage to list invoices
            invoicesPagination: {
                totalItems: 0,
                pages: 0,
                fistPage: 0,
                lastPage: 0,
            }
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
        async fetchCurrentInvoices(): Promise<Invoice[]> {
            const auth = useAuthStore();

            const companyId = auth.user?.company.id;
            if(!companyId){
                await auth.fetchAuthUser();
            }

            try {
                const response = await axios.get("/api/v1/invoice", {
                    params: {
                        sender_company_id: [auth.user?.company.id],
                        status: [InvoiceStatus.IN_PROGRESS],
                    },
                });

                this.invoices = response.data.data;
                this.invoicesPagination.totalItems =  response.data.meta.total;

                return response.data.data;
            } catch (error) {
                console.error("Не удалось загрузить счета", error);
                throw error;
            }
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

