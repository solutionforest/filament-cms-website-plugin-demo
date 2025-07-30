import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'
import postcss from '@tailwindcss/postcss';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/filament/admin/theme.css',
                'resources/css/contact-form.css',
                'resources/js/contact-form.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    css: {
        postcss: {
            plugins: [
                postcss,
            ],
        },
    },
});
