import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import jQuery from "jquery";
import DataTable from 'datatables.net-bs5';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss', // Our new line you can change app.scss to whatever.scss
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
