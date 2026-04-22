import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

function getExtensionAssets() {
    const basePath = path.resolve(__dirname, 'extensions');
    const inputs = [];

    if (!fs.existsSync(basePath)) return inputs;

    const extensions = fs.readdirSync(basePath);
    for (const ext of extensions) {
        const jsPath = path.join(basePath, ext, 'js', 'app.js');
        const cssPath = path.join(basePath, ext, 'css', 'app.css');

        if (fs.existsSync(jsPath)) {
            inputs.push(`extensions/${ext}/js/app.js`);
        }
        if (fs.existsSync(cssPath)) {
            inputs.push(`extensions/${ext}/css/app.css`);
        }
    }

    return inputs;
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...getExtensionAssets(), // Ajout dynamique ici
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery',
            'trumbowyg': path.resolve(__dirname, 'node_modules/trumbowyg'),
            'jQuery': 'jquery',
        },
    },
});
