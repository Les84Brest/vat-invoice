export interface DataTablesResponse<T> {
    draw: number;
    recordsTotal: number;
    recordsFiltered: number;
    data: T[];
}

export interface DataTablesAjaxRequest {
    draw: number;
    start: number;
    length: number;
    search: {
        value: string;
        regex: boolean;
    };
    order: Array<{
        column: number;
        dir: 'asc' | 'desc';
    }>;
    columns: Array<{
        data: string;
        name: string;
        searchable: boolean;
        orderable: boolean;
        search: {
            value: string;
            regex: boolean;
        };
    }>;
}
