import { InvoiceStatus, InvoiceType } from "@/types/invoice";

export function getStatusText(status: string): string {
    switch (status) {
        case InvoiceStatus.IN_PROGRESS:
            return "В разработке";
        case InvoiceStatus.IN_PROGRESS_ERROR:
            return "Ошибка";
        case InvoiceStatus.ON_AGREEMENT:
            return "На согласовании";
        case InvoiceStatus.COMPLETED_SIGNED:
            return "Выставлен. Подписан получателем";
        case InvoiceStatus.COMPLETED:
            return "Выставлен";
        case InvoiceStatus.ON_AGREEMENT_CANCEL:
            return "Выставлен. Аннулирован поставщиком";
        case InvoiceStatus.CANCELLED:
            return "Аннулирован";
        default:
            return "";
    }
}

export function getTypeText(status: string): string {
    switch (status) {
        case InvoiceType.ORIGINAL:
            return "Исходный";
        case InvoiceType.CORRECTED:
            return "Исправленный";

        default:
            return "";
    }
}
