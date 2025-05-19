const COMPANY_ASSIGNED_KEY = "isCompanyAssigned";

export const setAuthStatus = (status: boolean) => {
    const textStatus = status ? "true" : "false";
    window.localStorage.setItem("auth", textStatus);
};

export const getAuthStatus = () => {
    const localStorageStatus = window.localStorage.getItem("auth");

    if (localStorageStatus && localStorageStatus === "true") {
        return true;
    }

    return false;
};

export const getCompanyAssigmentStatus = () => {
    const localStorageStatus =
        window.localStorage.getItem(COMPANY_ASSIGNED_KEY);

    if (localStorageStatus && localStorageStatus === "true") {
        return true;
    }

    return false;
};

export const setCompanyAssigned = () => {
    localStorage.setItem(COMPANY_ASSIGNED_KEY, "true");
};

export const canselCompanyAssigned = () => {
    localStorage.removeItem(COMPANY_ASSIGNED_KEY);
};
