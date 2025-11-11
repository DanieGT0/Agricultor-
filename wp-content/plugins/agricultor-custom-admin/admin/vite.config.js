import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [react()],
    build: {
        outDir: 'dist',
        emptyOutDir: true,
        rollupOptions: {
            output: {
                entryFileNames: 'index.js',
                chunkFileNames: '[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    const info = assetInfo.name.split('.');
                    const ext = info[info.length - 1];
                    if (/png|jpe?g|gif|tiff|bmp|ico/i.test(ext)) {
                        return `images/[name][extname]`;
                    } else if (/woff|woff2|ttf|otf|eot/i.test(ext)) {
                        return `fonts/[name][extname]`;
                    } else if (ext === 'css') {
                        return `index.css`;
                    }
                    return `[name][extname]`;
                },
            },
        },
    },
    server: {
        hmr: {
            host: 'localhost',
            port: 5173,
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './src'),
        },
    },
});
