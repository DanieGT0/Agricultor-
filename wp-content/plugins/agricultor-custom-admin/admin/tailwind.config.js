/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './index.html',
        './src/**/*.{js,jsx}',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#F0F5E8',
                    100: '#D4E5D4',
                    200: '#B8D5C0',
                    300: '#9CC5AC',
                    400: '#80B598',
                    500: '#2D5016',
                    600: '#24410D',
                    700: '#1B3009',
                    800: '#132005',
                    900: '#0A1002',
                },
                secondary: {
                    50: '#F1F7E8',
                    100: '#D5E9BB',
                    200: '#B9DB8E',
                    300: '#9DCD61',
                    400: '#81BF34',
                    500: '#7CB342',
                    600: '#68933B',
                    700: '#547333',
                    800: '#40532B',
                    900: '#2C3323',
                },
                accent: '#FFB800',
            },
            fontFamily: {
                sans: ['Inter', 'Segoe UI', 'sans-serif'],
            },
            fontSize: {
                xs: ['12px', '16px'],
                sm: ['14px', '20px'],
                base: ['16px', '24px'],
                lg: ['18px', '28px'],
                xl: ['20px', '28px'],
                '2xl': ['24px', '32px'],
                '3xl': ['32px', '40px'],
            },
            spacing: {
                xs: '4px',
                sm: '8px',
                md: '16px',
                lg: '24px',
                xl: '32px',
                '2xl': '48px',
            },
            borderRadius: {
                sm: '4px',
                md: '8px',
                lg: '12px',
                xl: '16px',
            },
            boxShadow: {
                sm: '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                md: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                lg: '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
                xl: '0 20px 25px -5px rgba(0, 0, 0, 0.1)',
            },
        },
    },
    plugins: [],
};
