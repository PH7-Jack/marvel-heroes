const { blueGray, red } = require('tailwindcss/colors')

module.exports = {
    presets: [
        require('./vendor/ph7jack/wireui/tailwind.config.js')
    ],
    purge: [
        './app/Views/**/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/ph7jack/wireui/resources/**/*.blade.php',
        './vendor/ph7jack/wireui/ts/**/*.ts',
        './vendor/ph7jack/wireui/src/View/**/*.php'
    ],
    darkMode: false,
    theme: {
        extend: {
            colors: {
                blueGray,
                primary: red
            },
            boxShadow: {
                'soft': '3px 3px 16px #446b8d33'
            },
            fontSize: {
                '2xs': '.5rem'
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
