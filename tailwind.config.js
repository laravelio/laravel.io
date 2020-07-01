const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    extend: {
      colors: {
        green: {
          light: '#baebe1',
          primary: '#18bc9c',
          dark: '#15a589',
          darker: '#12826c',
        },
        red: {
          primary: '#e53e3e',
          dark: '#c53030',
        }
      },
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  variants: {},
  plugins: [
    require('@tailwindcss/ui'),
  ],
};
