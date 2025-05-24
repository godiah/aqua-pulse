import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                heading: ['Montserrat', ...defaultTheme.fontFamily.sans],
                body: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#00796b',
                'primary-hover': '#009688',
                secondary: '#4dd0e1',
                accent: '#ffc107',
                light: '#fafafa',
                dark: '#263238',
                border: '#b0bec5',
            },
        },
    },
    plugins: [forms],
};
