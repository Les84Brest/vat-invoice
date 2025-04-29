import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],

            },
            colors: {
                'dark-blue': '#1d3557',
                'text-color': '#173038',
                'light-green': '#f1faee',
                'light-gray': '#ebf2fa',
                'primary-color': '#409eff',
                'button-hover-bg': '#79bbff',
            },
            backgroundImage: {
                'welcome-bg': "url('/public/assets/images/welcome-bg.webp')",
            }
        },
    },
    plugins: [],
};
