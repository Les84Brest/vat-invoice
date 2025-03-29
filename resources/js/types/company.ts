export type Company = {
    id: number;
    title: string;
    short_title?: string;
    address?: string;
    tax_id: number;
    last_invoice_number?: number;
};
