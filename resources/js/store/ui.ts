import { defineStore } from "pinia";
import { ConfirmPasswordStatus } from "@/types/ui";

interface UiState {
    isPasswordConfirmDialogVisible: boolean;
    confirmationStatus: ConfirmPasswordStatus;
}

// Password confirmation statuses should be changed in this order
// CONFIRMATION_NOT_ASKED
// CONFIRMATION_PENDING
// CONFIRMATION_SUCCES | CONFIRMATION_FAILED (after response from backend will be recieved)

export const useUiStore = defineStore("ui", {
    state: (): UiState => {
        return {
            isPasswordConfirmDialogVisible: false,
            confirmationStatus: ConfirmPasswordStatus.CONFIRMATION_NOT_ASKED,
        };
    },

    actions: {
        togglePasswordConfirm() {
            this.isPasswordConfirmDialogVisible =
                !this.isPasswordConfirmDialogVisible;
        },
        setConfirmPasswordStatus(status: ConfirmPasswordStatus) {
            this.confirmationStatus = status;
        },
    },
});
