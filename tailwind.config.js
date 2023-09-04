const defaultTheme = require('tailwindcss/defaultTheme');
const defaultColors = require('tailwindcss/colors');

module.exports = {
    variants: {
        extend: {
            backgroundColor: ['active'],
        },
    },
    theme: {
        extend: {
            backgroundImage: {
                'gradient-radial': 'radial-gradient(circle farthest-corner at center, var(--tw-gradient-stops))',
            }
        }
    },
    content: [
        './app/**/*.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.twig',
        "./node_modules/tw-elements/dist/js/**/*.js"
    ],
    plugins: [
        // require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require("tw-elements/dist/plugin.cjs")
    ],
    // safelist: [
    //     {
    //         pattern: /./
    //     }
    // ]
    // darkMode: "class"
}
