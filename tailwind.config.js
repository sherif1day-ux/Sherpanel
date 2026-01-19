/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                neon: {
                    cyan: '#00f3ff',
                    pink: '#ff00ff',
                    purple: '#bc13fe',
                    dark: '#0a0a12',
                    surface: '#12121f',
                }
            },
            boxShadow: {
                'neon-cyan': '0 0 5px #00f3ff, 0 0 10px #00f3ff',
                'neon-pink': '0 0 5px #ff00ff, 0 0 10px #ff00ff',
            },
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
                mono: ['Fira Code', 'monospace'],
            }
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
