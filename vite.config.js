import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Path ke file CSS utama Anda
                'resources/js/app.js'   // Path ke file JavaScript utama Anda
            ],
            refresh: true, // Otomatis refresh browser saat ada perubahan di blade files
        }),
    ],
});
