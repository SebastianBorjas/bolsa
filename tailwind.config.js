import { defineConfig } from 'tailwindcss';

export default defineConfig({
    // Files and directories to scan when generating utilities.
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/**/*.blade.php',
        './storage/framework/views/**/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.ts',
        './routes/**/*.php',
    ],
    theme: {
        extend: {},
    },
    plugins: [],
});
