import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import collectModuleAssetsPaths from './vite-module-loader.js';

async function getConfig() {
    const paths = [
        'resources/css/app.css',
        'resources/js/app.js',
        'Modules/Remote/Core/resources/css/filament/admin/theme.css',
    ];
    const allPaths = await collectModuleAssetsPaths(paths, ['Modules/Local', 'Modules/Remote']);

    return defineConfig({
        plugins: [
            laravel({
                input: allPaths,
                refresh: true,
            }),
            tailwindcss(),
        ],
        server: {
            watch: {
                ignored: ['**/storage/framework/views/**'],
            },
        },
    });
}

export default getConfig();
