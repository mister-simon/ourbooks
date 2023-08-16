import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { refreshPaths } from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: [{
                paths: refreshPaths,
                config: { delay: 1000 }
            }],
        }),
    ],
})
