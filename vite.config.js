import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import fs from 'fs'

const isDev = process.env.APP_ENV === 'local' || process.env.NODE_ENV !== 'production'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [`resources/views/**/*`],
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
    ...(isDev && {
        server: {
            https: {
                key: fs.readFileSync('./docker/nginx/ssl/server.key'),
                cert: fs.readFileSync('./docker/nginx/ssl/server.crt'),
            },
            host: 'localhost',
            port: 5173,
            cors: true,
            origin: 'http://localhost:5173',
        },
    }),
});
