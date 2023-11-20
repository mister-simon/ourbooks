import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { refreshPaths } from "laravel-vite-plugin";
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
    server: {
        watch: {
            ignored: ['**/vendor/**']
        }
    },
    plugins: [
        VitePWA({
            scope: '/',
            base: '/',
            buildBase: '/build/',
            includeAssets: ['/favicon.ico', '/apple-touch-icon.png', '/mask-icon.svg'],
            manifest: {
                id: '/',
                scope: '/',
                name: 'OurBooks.top',
                short_name: 'OurBookstop',
                description: 'A webapp for sharing your bookshelves with friends.',
                theme_color: '#ffffff',
                icons: [
                    {
                        src: '/pwa-64x64.png',
                        sizes: '64x64',
                        type: 'image/png'
                    },
                    {
                        src: '/pwa-192x192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: '/pwa-512x512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    },
                    {
                        src: '/pwa-512x512.png',
                        sizes: '512x512',
                        type: 'image/png',
                        purpose: 'any'
                    },
                    {
                        src: '/maskable-icon-512x512.png',
                        sizes: '512x512',
                        type: 'image/png',
                        purpose: 'maskable'
                    }
                ]
            }
        }),
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: [{
                paths: refreshPaths,
                config: { delay: 1000 }
            }],
        }),
    ],
})
