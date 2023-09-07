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
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
    ],
    plugins: [
        // require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require("daisyui")
    ],
}
