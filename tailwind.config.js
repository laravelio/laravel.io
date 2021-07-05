const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],
    theme: {
        container: {
            screens: {
                sm: '640px',
                md: '768px',
                lg: '1024px',
                xl: '1280px',
                '2xl': '1280px',
            },
        },
        extend: {
            colors: {
                lio: {
                    100: '#e6f6f3',
                    200: '#a3ecde',
                    300: '#6ee2cc',
                    400: '#43d4b8',
                    500: '#18bc9c',
                    600: '#14a88b',
                    700: '#0e8b73',
                    800: '#0a6553',
                    900: '#053c31',
                },
                gray: {
                    100: '#f9fafb',
                    200: '#dfdfdf',
                    300: '#cbcbcb',
                    400: '#b2b2b2',
                    500: '#989898',
                    600: '#7e7e7e',
                    700: '#636363',
                    800: '#484a4a',
                    900: '#343636',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            maxWidth: {
                '14': '14rem',
            },
        },
    },
    variants: {},
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
