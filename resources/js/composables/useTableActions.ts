import { useRouter } from "vue-router";

export default function useTableActions() {
    const router = useRouter();

    const submitInvoice = (id: number) => {
        console.log(
            "%csubmit invoice in composable",
            "padding: 5px; background: DarkKhaki; color: Yellow;"
        );
    };

    const cancelInvoice = (id: number) => {
        console.log(
            "%ccancel invoice in composable",
            "padding: 5px; background: #3dd; color: #333333;"
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
