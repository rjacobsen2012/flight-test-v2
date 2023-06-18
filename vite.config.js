import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            sass: ['resources/sass/app.scss', 'public/css'],
            refresh: true,
        }),
    ],
});
