const { blueGray } = require('tailwindcss/colors')

module.exports = {
    purge: [
        './app/Views/**/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    darkMode: false,
    theme: {
        extend: {
            colors: {
                blueGray,
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
