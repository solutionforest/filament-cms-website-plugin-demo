import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'
import postcss from '@tailwindcss/postcss';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/filament/admin/theme.css'
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
