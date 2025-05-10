export const addLeadingZeros = (value: number, length: number) => {
    const digitFormatter = new Intl.NumberFormat("en-US", {
        minimumIntegerDigits: length,
        useGrouping: false,
    });

    return digitFormatter.format(value);
};

export const formatVatRate = (rate: string): string => {
    switch (rate) {
        case "Без НДС":
            return rate;

        default:
            return `${+rate * 100}`;
    }
};

export const formatCurrency = (sum: number) => {
    console.log('currency', sum);
    
    const currencyFormatter = new Intl.NumberFormat('ru-RU', {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    return  currencyFormatter.format(sum);
}