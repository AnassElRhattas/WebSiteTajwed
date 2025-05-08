import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    safelist: [
        'ham_wasl',
        'slnt',
        'laam_shamsiyah',
        'madda_normal',
        'madda_permissible',
        'madda_necessary',
        'madda_pbligatory',
        'qlq',
        'ikhf_shfw',
        'ikhf',
        'idghm_shfw',
        'iqlb',
        'idgh_ghn',
        'idgh_w_ghn',
        'idgh_mus',
        'ghn',
      ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
