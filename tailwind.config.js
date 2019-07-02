const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  theme: {
    colors: {
      white: '#ffffff',
      black: '#000000',
      green: {
        primary: '#18bc9c',
        dark: '#15a589',
        darker: '#12826c'
      },
      gray: {
        ...defaultTheme.colors.gray
      }
    },
    extend: {
      fontFamily: {
        sans: [
          'Lato',
          ...defaultTheme.fontFamily.sans,
        ]
      },
    }
  },
  variants: {},
  plugins: []
}
