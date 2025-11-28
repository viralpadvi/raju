import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/storefront.css',
                'resources/css/admin.css',
                'resources/js/storefront.js',
                'resources/js/admin.js'
            ],
            refresh: true,
        }),
    ],
    css: {
        postcss: {
            plugins: {
                tailwindcss: {},
                autoprefixer: {},
            },
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs', 'axios'],
                    charts: ['chart.js'],
                    ui: ['@headlessui/vue', '@heroicons/vue']
                }
            }
        }
    }
});
