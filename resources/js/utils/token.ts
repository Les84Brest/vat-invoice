import axios from "axios";

/**
 * This function fetches sanctum auth token. After fetching this token must 
 * be saved in global axios object and then should be sent on every axios request
 * to backend
 * @returns Promise<boolean>
 */
export async function fetchCsrfTocken(): Promise<boolean> {
    const xcrfTokenUrl = "/sanctum/csrf-cookie";
    const response = await axios.get(xcrfTokenUrl);

    return response.status == 204 ? true : false;
}
