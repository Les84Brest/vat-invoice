import { defineStore } from "pinia";
import type { User } from "../types/user";
import { fetchCsrfTocken } from "../utils/token";
import axios, { AxiosResponse } from "axios";
import { ILoginForm } from "../types/user";

interface AuthState {
    isLogined: boolean;
    user: User | null;
}

export const useAuthStore = defineStore("auth", {
    state: (): AuthState => {
        return {
            isLogined: false,
            user: null,
        };
    },
    actions: {
        async loginIn(loginData: ILoginForm): Promise<boolean> {
            try {
                const isTokenFetched = await fetchCsrfTocken();

                if (isTokenFetched) {
                    const response = await axios.post("/login", loginData);

                    if (response.status == 204) {
                        window.localStorage.setItem("auth", "true");
                        this.isLogined = true;
                        this.fetchAuthUser();
                        
                        return true;
                    }
                }
            } catch (error) {
                throw new Error("Ошибка входа. Попробуйте еще раз.");
            }
            return false;
        },
        async fetchAuthUser(): Promise<void> {
            try {
                const response = await axios.get("/api/v1/auth_user");
                const authUser = response.data;

                this.user = authUser;
            } catch (error) {
                throw new Error("Ошибка получения данных пользователя");
            }
        },
    },
});
