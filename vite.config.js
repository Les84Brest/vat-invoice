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
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        }
    },
});


