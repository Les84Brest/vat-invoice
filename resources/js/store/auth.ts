import { defineStore, storeToRefs } from "pinia";
import type { User } from "../types/user";
import { fetchCsrfTocken } from "../utils/token";
import axios, { AxiosResponse } from "axios";
import { ILoginForm } from "../types/user";
import { setAuthStatus } from "@/utils/auth";
import { useRouter } from "vue-router";

interface AuthState {
    isLogined: boolean;
    user: User | null;
}

const router = useRouter();

export const useAuthStore = defineStore("auth", {
    state: (): AuthState => {
        return {
            isLogined: false,
            user: null,
        };
    },
    getters: {
        newInvoiceNumber: (state) => {
            const lastInvoiceNumber = state.user?.company.last_invoice_number;
            console.log('%clastinv', 'padding: 5px; background: hotpink; color: black;', typeof lastInvoiceNumber);

            if ((typeof lastInvoiceNumber === 'number') && lastInvoiceNumber >= 0) {
                return lastInvoiceNumber + 1;
            }

            return 0;
        },
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
                        router.push("/vat");
                        return true;
                    }
                }
            } catch (error) {
                throw new Error("Ошибка входа. Попробуйте еще раз.");
            }
            return false;
        },

        async logOut() {
            try {
                setAuthStatus(false);

                const response = await axios.post(
                    "/logout",
                    {},
                    {
                        withCredentials: true,
                    }
                );
                this.$reset();
                router.push("/login");
            } catch (error) {
                console.error("Logout failed:", error);
            }
        },
        async fetchAuthUser(): Promise<void> {
            try {
                const response = await axios.get("/api/v1/auth_user");
                const authUser = response.data.data;

                this.user = authUser;
            } catch (error) {
                throw new Error("Ошибка получения данных пользователя");
            }
        },
    },
});
