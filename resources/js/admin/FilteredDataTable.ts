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

    private handleFilterChange = (event: Event): void => {
        const target = event.target as HTMLSelectElement;

        this.updateFilters(target);
        this.dataTable?.ajax.reload();
    };

    private initializeFilters() {
        const multipleSelect = $(`${this.wrapSelector} ${MULTIPLE_SELECT_SELECTOR}`);

        multipleSelect.each(function () {
            $(this).select2();
        });

        multipleSelect.on("change", this.handleFilterChange);

        $(`${this.wrapSelector} .js-reset-filters`).on("click", () => {
            this.resetFilters();
        });
    }

    private resetFilters(): void {
        this.tableFilters = {};

        const multipleSelect = $(`${this.wrapSelector} ${MULTIPLE_SELECT_SELECTOR}`);
        multipleSelect.off("change", this.handleFilterChange);
        multipleSelect.val([]).trigger("change");
        multipleSelect.on("change", this.handleFilterChange);

        this.dataTable?.ajax.reload();
    }

    private updateFilters(filterSelect: HTMLSelectElement): void {
        const filterValues = $(filterSelect).val();
        const filterName = filterSelect.dataset.filterName;

        if (!filterName) {
            return;
        }

        if (!filterValues || (Array.isArray(filterValues) && filterValues.length === 0)) {
            delete this.tableFilters[filterName];
            return;
        }

        this.tableFilters[filterName] = filterValues;
    }

    private async fetchData(data: any, callback: Function): Promise<void> {
        try {
            const requestPage = Math.floor(data.start / data.length) + 1;
            const params = {
                ...this.tableFilters,
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
