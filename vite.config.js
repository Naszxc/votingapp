import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: {
                app: 'resources/js/app.js',
                login: 'resources/js/login.js',
            },
            refresh: true
        }),
        vue()
    ],
    alias: {
        '@': path.resolve(__dirname, 'resources/js')
    }
});
