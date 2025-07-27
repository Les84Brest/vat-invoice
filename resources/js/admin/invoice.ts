import { INVOICE_TABLE_WRAP_SELECTOR } from "./constants";
import $ from "jquery";
import "datatables.net";
import { formatCurrency } from "@/utils/format";
import { getStatusText, getTypeText } from "@/utils/invoice";
import { InvoiceListItem } from "@/types/invoice";
import axios, { AxiosRequestConfig, AxiosResponse } from "axios";
import { DataTablesAjaxRequest, DataTablesResponse } from "./types";

$(INVOICE_TABLE_WRAP_SELECTOR).DataTable({
    // Enable server-side processing
    serverSide: true,
    searching: false,

    ajax: async (data, callback) => {
        try {
            const requestPage = data.start / data.length;
            const params = {
                start: data.start,
                limit: data.length,
                search: data.search.value,
                orderColumn: data.order[0]?.column,
                orderDir: data.order[0]?.dir,
                page: requestPage,
            };

            const config: AxiosRequestConfig = {
                params,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
            };
            const response: AxiosResponse<DataTablesResponse<InvoiceListItem>> =
                await axios.get("/api/v1/invoice", config);

            callback({
                draw: data.draw,
                recordsTotal: response.data.meta.total,
                recordsFiltered: response.data.meta.total,
                data: response.data.data,
            });
        } catch (error) {}
    },
    columns: [
        {
            data: "number",
            title: "Номер",
            render: (data: string, type: any, row: InvoiceListItem) => {
                return `<a href="/admin/invoice/${row.id}">${data}</a>`;
            },
        },
        { data: "sender_company.title", title: "Отправитель" },
        { data: "recipient_company.title", title: "Получатель" },
        { data: "author.full_name", title: "Автор" },
        {
            data: "status",
            title: "Статус",
            render: (data: string) => {
                const statusText = getStatusText(data);
                const badgeSpan = document.createElement("span");
                badgeSpan.innerText = statusText;
                badgeSpan.className = "badge bg-warning";

                return badgeSpan;
            },
        },
        {
            data: "type",
            title: "Тип счета",
            render: (data: string) => {
                const typeText = getTypeText(data);
                const badgeSpan = document.createElement("span");
                badgeSpan.innerText = typeText;
                badgeSpan.className = "badge bg-warning";

                return badgeSpan;
            },
        },
        {
            data: "total_wo_vat",
            title: "Сумма без НДС",
            render: (data: number) => formatCurrency(data),
        },
        {
            data: "total_vat",
            title: "Сумма НДС",
            render: (data: number) => formatCurrency(data),
        },
        {
            data: "total",
            title: "Сумма c НДС",
            render: (data: number) => formatCurrency(data),
        },
    ],
});
