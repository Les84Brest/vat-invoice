import { Hide } from "@element-plus/icons-vue/dist/types";
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
            console.log(
                "%caxios response",
                "padding: 5px; background: DarkKhaki; color: Yellow;",
                resp
            );

            if (resp.status === 200) {
                window.location.href = "/admin";
            }
        } catch (error: unknown) {
            if (axios.isAxiosError(error)) {
                const axiosError = error as AxiosError;

                console.log(
                    "%cresponse axios error",
                    "padding: 5px; background: DarkGreen; color: MediumSpringGreen;",
                    axiosError.response?.data
                );

                errorNode?.classList.remove(HIDDEN_CLASS);
            }
        }

        // try {
        //     const response = await fetch("/admin/login", {
        //         method: "POST",
        //         headers: {
        //             "Content-Type": "application/json",
        //             Accept: "application/json",
        //         },
        //         body: JSON.stringify({
        //             email,
        //             password,
        //             _token: csrfToken,
        //         }),
        //     });

        //     console.log(
        //         "%cresp",
        //         "padding: 5px; background: hotpink; color: black;",
        //         response
        //     );

        //     const data: { message?: string; token?: string } =
        //         await response.json();

        //     if (!response.ok) {
        //         if (errorMsg)
        //             errorMsg.textContent = data.message || "Login failed";
        //     } else {
        //         if (errorMsg) errorMsg.textContent = "";
        //         alert(`Login successful! Token: ${data.token}`);
        //     }
        // } catch (error) {
        //     if (errorMsg) errorMsg.textContent = "Error connecting to server";
        // }
    });
});
