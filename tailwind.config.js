const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/macros/blade.php',
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
                twitter: '#00aaec',
                facebook: '#4267b2',
                linkedin: '#2977c9',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            minWidth: {
                8: '2rem',
            },
            maxWidth: {
                14: '14rem',
            },
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        color: theme('colors.gray.900'),
                        a: {
                            'text-decoration': 'none',
                            color: theme('colors.lio.500'),
                            'border-bottom': `2px solid ${theme('colors.lio.100')}`,
                            'padding-bottom': theme('padding')['0.5'],
                            '&:hover': {
                                color: theme('colors.lio.700'),
                            },
                        },
                        'code::before': {
                            content: '""',
                        },
                        'code::after': {
                            content: '""',
                        },
                        code: {
                            color: '#ec4073',
                            'background-color': 'rgba(236, 64, 115, 0.1)',
                            'border-radius': theme('borderRadius.DEFAULT'),
                            padding: `${theme('padding')[0.5]}`,
                        },
                    },
                },
            }),
        },
    },
    variants: {},
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
