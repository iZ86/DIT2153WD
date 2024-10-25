/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './public/**/*.{html,js,php}', // Include all files in public
    './Views/**/*.{html,js,php}',    // Include all files in Views
    './src/**/*.{html,js,php}',     // Include all files in src if applicable
    './Controller/**.{html,js,php}',
  ],
  theme: {
    extend: {
      colors: {
        'blue-user': '#F1FAFF',
        'blue-button' : '#5C7AFF',
        'gray-dove' : '#666666',
        'blue-light' : '#5C7AFF',
        'blue-neon' : '#4666FF'
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
