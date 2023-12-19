import forms from '@tailwindcss/forms';
//const colors = require('tailwindcss/colors')
//const defaultTheme = require('tailwindcss/defaultTheme')
///** @type {import('tailwindcss').Config} */
export default {
    important: true,
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/js/**/*.vue',
        './node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        './node_modules/flowbite/**/*.{js,jsx,ts,tsx}'
    ],

    /*safelist: [
        'w-64',
        'w-1/2',
        'rounded-l-lg',
        'rounded-r-lg',
        'bg-gray-200',
        'grid-cols-4',
        'grid-cols-7',
        'h-6',
        'leading-6',
        'h-9',
        'leading-9',
        'shadow-lg',
        'bg-opacity-50',
        'dark:bg-opacity-80'
    ],*/
    darkMode: "class",
    theme: {
        /*fontSize: {

          },*/

        /*screens: {
            sm: '480px',
            md: '768px',
            lg: '976px',
            xl: '1440px',
        },*/

        fontFamily: {
            'body': [
                'Roboto',
                'ui-sans-serif',
                'system-ui',
                '-apple-system',
                'system-ui',
                'Segoe UI',
                'Roboto',
                'Helvetica Neue',
                'Arial',
                'Noto Sans',
                'sans-serif',
                'Apple Color Emoji',
                'Segoe UI Emoji',
                'Segoe UI Symbol',
                'Noto Color Emoji'
            ],
            'sans': [
                'Roboto',
                'ui-sans-serif',
                'system-ui',
                '-apple-system',
                'system-ui',
                'Segoe UI',
                'Roboto',
                'Helvetica Neue',
                'Arial',
                'Noto Sans',
                'sans-serif',
                'Apple Color Emoji',
                'Segoe UI Emoji',
                'Segoe UI Symbol',
                'Noto Color Emoji'
            ]
        },

        extend: {
            fontSize: {
                //'validation': '0.8rem',
                'xs':'0.82rem',
                'sm': '0.9rem',
            },
            transitionProperty: {
                'width': 'width'
            },
            textDecoration: ['active'],
            minWidth: {
                'kanban': '28rem'
            },
            colors: {
                primary: { "50": "#eff6ff", "100": "#dbeafe", "200": "#bfdbfe", "300": "#93c5fd", "400": "#60a5fa", "500": "#3b82f6", "600": "#2563eb", "700": "#1d4ed8", "800": "#1e40af", "900": "#1e3a8a" }
              },
        },
    },
    plugins: [
        forms,

        require('flowbite/plugin')],
};
