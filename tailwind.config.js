import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // non-aktifkan deteksi dark mode otomatis OS (hanya aktif jika class 'dark' disetel manual di html)
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                serif: ['"Playfair Display"', 'serif'],
                cinzel: ['"Cinzel"', 'serif'],
            },
            colors: {
                tiket: {
                    blue: '#0064D2',
                    'blue-dark': '#0051A8',
                    'blue-light': '#E8F3FF',
                    yellow: '#FEDD00',
                    'yellow-hover': '#F5D300',
                    orange: '#F89C1D',
                    surface: '#F4F7FB',
                    dark: '#1A202C',
                    gray: '#687176',
                    border: '#E4EBF2',
                }
            },
            animation: {
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            }
        },
    },

    plugins: [forms],
};
