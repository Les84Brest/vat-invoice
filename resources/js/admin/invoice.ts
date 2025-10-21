import { INVOICE_TABLE_WRAP_SELECTOR } from "./constants";
import { FilteredDataTable } from "./FilteredDataTable";

document.addEventListener("DOMContentLoaded", () => {
    const vatTable = new FilteredDataTable(INVOICE_TABLE_WRAP_SELECTOR, `/api/v1/invoice`);
});


