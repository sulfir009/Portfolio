import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/js/edit_affiliates.js',
                'resources/css/app.css',
                'resources/css/api.css',
            ],
            refresh: true,
        }),
    ], build: {
        manifest: true,
    }
});
