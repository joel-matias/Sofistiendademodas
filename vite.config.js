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
    host: true,      // equivale a 0.0.0.0
    port: 5173,      // o el puerto que uses
    strictPort: true // opcional: falla si el puerto está ocupado
    }
});
