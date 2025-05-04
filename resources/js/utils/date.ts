export function formatDate(inputDate: string) {
    const date = new Date(inputDate);
    return new Intl.DateTimeFormat("ru-RU", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
    }).format(date);
}

export function formatDateForDatePicker(dateString: string): string {
    // Validate input format using regex
    const dateRegex = /^\d{2}\.\d{2}\.\d{4}$/;
    if (!dateRegex.test(dateString)) {
        throw new Error("Invalid date format. Expected DD.MM.YYYY");
    }

    // Split the date components
    const [day, month, year] = dateString.split(".");

    // Validate date components
    const dayNum = parseInt(day, 10);
    const monthNum = parseInt(month, 10);
    const yearNum = parseInt(year, 10);

    if (monthNum < 1 || monthNum > 12) {
        throw new Error("Invalid month value. Month must be between 01-12");
    }

    if (dayNum < 1 || dayNum > 31) {
        throw new Error("Invalid day value. Day must be between 01-31");
    }

    // Create ISO format string (YYYY-MM-DD)
    return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
}

export function getCurrentDate(): string {
    const date = new Date();
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0"); // Months are zero-based
    const day = String(date.getDate()).padStart(2, "0");

    return `${year}-${month}-${day}`;
}
