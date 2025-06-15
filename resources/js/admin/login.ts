import { LOGIN_FORM_CLASS, HIDDEN_CLASS, LOGIN_ERROR_CLASS } from "./constants";
import axios, { AxiosError, AxiosResponse } from "axios";

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById(
        LOGIN_FORM_CLASS
    ) as HTMLFormElement | null;
    const errorMsg = document.getElementById(
        "error-msg"
    ) as HTMLParagraphElement | null;

    if (!form) return;

    form.addEventListener("submit", async (e: Event) => {
        e.preventDefault();

        const errorNode = document.querySelector(LOGIN_ERROR_CLASS);

        errorNode?.classList.add(HIDDEN_CLASS);

        const emailInput = document.getElementById(
            "email"
        ) as HTMLInputElement | null;
        const passwordInput = document.getElementById(
            "password"
        ) as HTMLInputElement | null;

        if (!emailInput || !passwordInput) return;

        const csrfInput = document.querySelector(
            'input[name="_token"]'
        ) as HTMLInputElement | null;

        const csrfToken = csrfInput?.value;
        const email = emailInput.value;
        const password = passwordInput.value;

        try {
            const resp: AxiosResponse = await axios.post(
                "/admin/login",
                {
                    email,
                    password,
                    _token: csrfToken,
                },
                {
                    headers: {
                        "Content-Type": "application/json",
                    },
                }
            );

            if (resp.status === 200) {
                const userData = resp.data.user;
                window.localStorage.setItem("adminAuthUser", userData);
                window.location.href = "/admin";
            }
        } catch (error: unknown) {
            if (axios.isAxiosError(error)) {
                const axiosError = error as AxiosError<{ error: string }>;
                const errorLabel = errorNode?.querySelector(".js-error-label");

                if (errorLabel) {
                    errorLabel.innerHTML = "";
                }

                const errorText =
                    axiosError.response?.data?.error ??
                    "Неправильные реквизиты";

                errorLabel?.insertAdjacentText("beforeend", errorText);

                errorNode?.classList.remove(HIDDEN_CLASS);
            }
        }
    });
});
