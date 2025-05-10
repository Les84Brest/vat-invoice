import type { TableColumnCtx } from "element-plus";
import type { InvoiceItem } from "@/types/invoice";
import { formatCurrency } from "@/utils/format";

interface SummaryMethodProps<T = InvoiceItem> {
    columns: TableColumnCtx<T>[];
    data: T[];
}

export default function useVatTableSummaries(
    notSummarizedColumns: Array<string> = [],
    totalLabel: string = "Всего"
) {
    const tableSummaries = (param: SummaryMethodProps) => {
        const { columns, data } = param;
        const sums: Array<string> = [];

        columns.forEach((col, index) => {
            if (index === 0) {
                sums[index] = totalLabel;
            }

            const colName = col.property as string;

            if (notSummarizedColumns.includes(colName)) {
                return;
            }

            const values = data.map((item) =>
                Number(item[colName as keyof InvoiceItem])
            );
            if (!values.every((value) => Number.isNaN(value))) {
                sums[index] = `${values.reduce((prev, curr) => {
                    const value = Number(curr);
                    if (!Number.isNaN(value)) {
                        return prev + curr;
                    } else {
                        return prev;
                    }
                }, 0)}`;
            }
        });

        return sums.map((col, i) => {
            if (i === 0) return col;
            return formatCurrency(+col * 1);
        });
    };

    return tableSummaries;
}
