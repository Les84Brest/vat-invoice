import { Company } from "./company";
import { User } from "./user";

//basic invoice type
export type Invoice = {
    id: number;
    number: string;
    creation_date: string;
    action_date: string;
    status: InvoiceStatus;
    type: InvoiceType;
    total_wo_vat: number;
    total_vat: number;
    total: number;
    sender_company: Company;
    author: User;
    recipient_company: Company;
    signatory?: User;
    contract_number: string;
    contract_date: string;
    delivery_documents?: Array<DeliveryDocument>;
    parent_invoice?: Invoice;
    invoice_items: Array<InvoiceItem>;
};
// type for new invoice creation
export type NewInvoice = Omit<
    Invoice,
    "sender_company" | "recipient_company" | "author" | "id" | "parent_invoice"
> & {
    sender_company_id: number;
    recipient_company_id: number;
    author_id: number;
};

// type for showing invoices list in table  
export type InvoiceListItem = Omit<
    Invoice,
    | "contract_date"
    | "contract_number"
    | "delivery_documents"
    | "invoice_items"
    | "parent_invoice"
    | "signatory"
> & {
    author_name: string,
    signatory_name?: string
};

export type DeliveryDocument = {
    id: string;
    document_type: string;
    number: string;
    date: string;
};

export interface InvoiceItem {
    id: string;
    name: string;
    dimension: string;
    count: number;
    price: number;
    cost: number;
    vat_rate: number | string;
    vat_sum: number;
    cost_vat: number;
}

//invoice type
export enum InvoiceType {
    ORIGINAL = "ORIGINAL",
    CORRECTED = "CORRECTED",
}

export function isInvoiceType(value: string): value is InvoiceType {
    return Object.values(InvoiceType).includes(value as InvoiceType);
}

export function toInvoiceType(value: string): InvoiceType {
    if (isInvoiceType(value)) {
        return value;
    }
    throw new Error(`Invalid InvoiceType: ${value}`);
}

//invoice status
export enum InvoiceStatus {
    IN_PROGRESS = "IN_PROGRESS",
    IN_PROGRESS_ERROR = "IN_PROGRESS_ERROR",
    ON_AGREEMENT = "ON_AGREEMENT",
    COMPLETED_SIGNED = "COMPLETED_SIGNED",
    COMPLETED = "COMPLETED",
    ON_AGREEMENT_CANCEL = "ON_AGREEMENT_CANCEL",
    CANCELLED = "CANCELLED",
}

export function isInvoiceStatus(value: string): value is InvoiceStatus {
    return Object.values(InvoiceStatus).includes(value as InvoiceStatus);
}

export function toInvoiceStatus(value: string): InvoiceStatus {
    if (isInvoiceStatus(value)) {
        return value;
    }
    throw new Error(`Invalid InvoiceStatus: ${value}`);
}

