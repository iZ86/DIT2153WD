/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './public/**/*.{html,js,php}', // Include all files in public
    './Views/**/*.{html,js,php}',    // Include all files in Views
    './src/**/*.{html,js,php}',     // Include all files in src if applicable
  ],
  theme: {
    extend: {
      colors: {
        'white-bg': '#F1FAFF',
        'blue-button' : '#5C7AFF',
      },
      fontFamily: {
        montserrat: ["Montserrat", "sans-serif"],
        nunito: ["Nunito", "sans-serif"],
        orelega: ["Orelega One", "sans-serif"],
        aoboshi: ["Aoboshi One", "serif"],
      },
    },
  },
  plugins: [],
};
