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
        'blue-neon' : '#4666FF',
        'blue-vivid' : '#1CA3EC',
        'gray-mid' : '#AAAAAA',
        'gray-light' : '#D9D9D9',
      },
      fontFamily: {
        montserrat: ["Montserrat", "sans-serif"],
        nunito: ["Nunito", "sans-serif"],
        orelega: ["Orelega One", "sans-serif"],
        aoboshi: ["Aoboshi One", "serif"],
      },
      dropShadow: {
        'dark' : '0 4px 2px rgb(0 0 0 / 0.25)',
      },
      borderRadius: {
        '4xl' : '2.5rem',
      },
      width: {
        '15' : '3.75rem',
      },
      flexBasis: {
        '128' : '32rem',
        '192' : '48rem',
        '256' : '64rem',
      },
      minWidth: {
        '192' : '48rem',
        '256' : '64rem',
      },
      minHeight: {
        '192' : '48rem',
      }
    },
  },
  plugins: [],
};
