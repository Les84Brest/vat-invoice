import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import router from './router';

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.response.use(
    (response) => {
        // For successful responses (2xx), just pass them through
        return response;
    },
    (error) => {
        if (!error.response) {
            // Network error or no response
            return Promise.reject(error);
        }

        const { status } = error.response;

        // Handle specific status codes
        if (status === 401 || err.response.status === 419) {
            const auth = localStorage.getItem('auth');
            if (auth) {
                localStorage.removeItem('auth');
            }
            router.push({ name: 'welcome.login' });
        }

        return Promise.reject(error);
    }
);

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
