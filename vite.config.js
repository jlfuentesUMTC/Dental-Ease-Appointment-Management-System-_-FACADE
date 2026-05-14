import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        https: false, 
        host: '0.0.0.0', 
        // Let Vite use the page host so phones on the LAN do not request assets from localhost.
        hmr: true,
    },
});
