const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: ['./resources/**/*.blade.php', './resources/**/*.js'],
    theme: {
        extend: {
            colors: {
                lio: {
                    100: '#d1f2eb',
                    200: '#a3e4d7',
                    300: '#74d7c4',
                    400: '#46c9b0',
                    500: '#18bc9c',
                    600: '#15a589',
                    700: '#0e715e',
                    800: '#0a4b3e',
                    900: '#05261f',
                },
            },
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {},
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
