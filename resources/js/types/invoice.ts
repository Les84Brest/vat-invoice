import { Company } from "./company"
import { User } from "./user"

export type Invoice = {
    id: number,
    number: string,
    creation_date: string,
    action_date: string,
    status: string,
	type: string,
    total_wo_vat: number,
    total_vat: number,
    total: number,
    sender_company: Company
    author: User,
    recipient_company: Company,
    signatory?: User,
	contract_number: string,
    contract_date: string
    delivery_documents?: object,
    parent_invoice?: Invoice
}