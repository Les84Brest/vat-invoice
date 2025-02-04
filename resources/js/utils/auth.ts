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

