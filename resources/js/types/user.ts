import { Company } from "./company";

export type User = {
    id: number;
    name: string;
    last_name: string;
    full_name: string;
    email: string;
    company: Company;
};

export interface ILoginForm {
    email: string,
    password: string
}

export interface IRegisterForm {
    name: string,
    last_name: string,
    email: string,
    password: string
    password_confirmation: string
}