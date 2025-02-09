export const addLeadingZeros = (value: number, length: number) => {
    const digitFormatter = new Intl.NumberFormat("en-US", {
        minimumIntegerDigits: length,
        useGrouping: false,
    });

    return digitFormatter.format(value);
};
