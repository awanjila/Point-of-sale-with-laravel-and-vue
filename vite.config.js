import { defineConfig } from 'vite';
import path from 'path'; // Import the 'path' module
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/app.css', // Include the CSS file as an input
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '/@': path.resolve(__dirname, 'src'), // Correct alias usage
            '/~': path.resolve(__dirname, 'resources'), // Correct alias usage
        },
    },
    build: {
        manifest: true, // Enable generation of asset manifest
        rollupOptions: {
            output: {
                // Remove or comment out the manualChunks configuration if not needed
                // manualChunks: {
                //     vendor: ['vue'], // Add other libraries if necessary
                // },
            },
        },
    },
});
