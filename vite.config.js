import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Mengizinkan akses dari perangkat lain
        port: 5173, // Port default Vite
        hmr: {
            host: 'localhost', // Atau URL Ngrok jika diperlukan
        },
    },
});
