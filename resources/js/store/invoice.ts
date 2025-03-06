import { defineStore } from "pinia";
import { InvoiceItem } from "@/types/invoice";

interface InvoiceState {
    invoiceItems: Array<InvoiceItem>;
}

export const useInvoiceStore = defineStore("invoice", {
    state: (): InvoiceState => {
        return {
            invoiceItems: [],
        };
    },
    actions: {
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
