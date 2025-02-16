export function formatDate(inputDate: string) {
    const date = new Date(inputDate);
    return new Intl.DateTimeFormat("ru-RU", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
    }).format(date);
}
