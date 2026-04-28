import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/admin/style.scss',
                'resources/js/app.ts',
                'resources/css/app.css',
                'resources/js/admin/login.ts',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, 'resources/js'),
            '@pages': path.resolve(__dirname, 'resources/js/pages'),
            '@components': path.resolve(__dirname, 'resources/js/components'),
            '@layouts': path.resolve(__dirname, 'resources/js/layouts'),
            '@stores': path.resolve(__dirname, 'resources/js/store'),
            '@assets': path.resolve(__dirname, 'public/assets/'),
        },
    },
    server: {
        host: '0.0.0.0', // Важно: слушаем все интерфейсы
        port: 5173,
        hmr: {
            host: 'vat-invoice.loc', // Домен, который вы используете
            port: 5173,
            protocol: 'ws', // WebSocket protocol
        },
        cors: true, // Разрешаем CORS для разработки
        strictPort: true, // Используем только указанный порт
    },
});