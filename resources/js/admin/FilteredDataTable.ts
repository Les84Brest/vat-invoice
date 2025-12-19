import axios, { AxiosRequestConfig, AxiosResponse } from "axios";
import { DataTablesResponse } from "./types";
import { InvoiceListItem } from "@/types/invoice";
import { getStatusText, getTypeText } from "@/utils/invoice";
import { formatCurrency } from "@/utils/format";
import { MULTIPLE_SELECT_SELECTOR } from "./constants";

export class FilteredDataTable {
    dataTable: DataTables.Api | null;
    wrapSelector: string;
    private apiUrl: string;
    private tableFilters: Record<string, string> = {};

    constructor(tableWrapSelector: string, apiUrl: string) {
        this.apiUrl = apiUrl;
        this.dataTable = null;
        this.wrapSelector = tableWrapSelector;

        this.initializeTable();
        this.initializeFilters();
    }

    private initializeTable = (): void => {

        this.dataTable = $(`${this.wrapSelector} .js-data-table`).DataTable({
            processing: true,
            serverSide: true,
            ajax: (data, callback) => this.fetchData(data, callback),
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

                        // return `<span class="badge bg-warning">${statusText}</span>`;
                        return badgeSpan.outerHTML;
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

                        return badgeSpan.outerHTML;
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
    };

    private initializeFilters() {
        const self = this;

        $(`${this.wrapSelector} ${MULTIPLE_SELECT_SELECTOR}`).each(function () {
            $(this).select2();
        });

        //initializing change event

        $(`${this.wrapSelector} ${MULTIPLE_SELECT_SELECTOR}`).on(
            "change",
            function (event) {
    
                self.updateFilters(event.target);
                self.dataTable?.ajax.reload();
            }
        );
    }

    private updateFilters(filterSelect) {
        const filterValues = $(filterSelect).val();
        const filterName = filterSelect.dataset.filterName;

        this.tableFilters[filterName] = filterValues;
    }

    private async fetchData(data: any, callback: Function): Promise<void> {
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
                await axios.get(this.apiUrl, config);

            callback({
                draw: data.draw,
                recordsTotal: response.data.meta.total,
                recordsFiltered: response.data.meta.total,
                data: response.data.data,
            });
        } catch (error) {
            console.error("Ошибка при получении счетов: ", error);
            callback({
                draw: data.draw,
                recordsTotal: 0,
                recordsFiltered: 0,
                data: [],
            });
        }
    }
}
