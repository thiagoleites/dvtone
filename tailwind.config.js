/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./functions/**/*.php",
    "./template-parts/**/*.php",
    "./inc/**/*.php",
    "./assets/js/**/*.js",
    "./assets/css/**/*.css",
  ],
  theme: {
    extend: {
      maxWidth: {
        'site': '1400px',
      },
      colors: {
        primary: '#1E3A8A',
        secondary: '#F59E0B',
        accent: '#10B981',
      },
    },
  },
  plugins: [],
}

