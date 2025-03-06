import { Company } from "./company";
import { User } from "./user";

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

export type NewInvoice = Omit<
    Invoice,
    | "sender_company"
    | "recipient_company"
    | "author"
    | "id"
    | "parent_invoice"
> & {
    sender_company_id: number;
    recipient_company_id: number;
    author_id: number;
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

export enum InvoiceType {
    ORIGINAL = "ORIGINAL",
    CORRECTED = "CORRECTED",
}

export enum InvoiceStatus {
    IN_PROGRESS = "IN_PROGRESS",
    IN_PROGRESS_ERROR = "IN_PROGRESS_ERROR",
    ON_AGREEMENT = "ON_AGREEMENT",
    COMPLETED_SIGNED = "COMPLETED_SIGNED",
    COMPLETED = "COMPLETED",
    ON_AGREEMENT_CANCEL = "ON_AGREEMENT_CANCEL",
    CANCELLED = "CANCELLED",
}
