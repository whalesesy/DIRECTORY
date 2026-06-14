/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        kisii: {
          blue:    { DEFAULT: '#1B4F8A', light: '#2A6CB5', dark: '#0F3460' },
          green:   { DEFAULT: '#1F7A3A', light: '#2E9B52', dark: '#145A28' },
          gold:    { DEFAULT: '#D4A017', light: '#E8C04A', dark: '#A67C00' },
          white:   '#FFFFFF',
          surface: '#F7FAFC',
          border:  '#E2E8F0',
          text:    { DEFAULT: '#1A2E44', muted: '#5A6F85' },
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
      animation: {
        'fade-in': 'fadeIn 0.4s ease-out',
        'slide-up': 'slideUp 0.4s ease-out',
        'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
      },
      keyframes: {
        fadeIn: { from: { opacity: 0 }, to: { opacity: 1 } },
        slideUp: { from: { opacity: 0, transform: 'translateY(16px)' }, to: { opacity: 1, transform: 'translateY(0)' } },
        pulseSoft: { '0%,100%': { opacity: 1 }, '50%': { opacity: 0.7 } },
      },
    },
  },
  plugins: [],
  safelist: [
    { pattern: /border-t-kisii-(blue|green|gold)(-light|-dark)?/ },
  ],
}
