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
        'blue-mid' : '#1085C5',
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
        '144' : '36rem',
        '192' : '48rem',
        '256' : '64rem',
      },
      minWidth: {
        '84' : '21rem',
        '100' : '25rem',
        '192' : '48rem',
        '236' : '59rem',
        '256' : '64rem',
      },
      minHeight: {
        '128' : '32rem',
        '144' : '36rem',
        '192' : '48rem',
      },
      maxWidth: {
        '128' : '32rem',
        '144' : '36rem',
        '192' : '48rem',
        '256' : '64rem',
      },
      maxHeight: {
        '192' : '48rem',
      },
      inset: {
        '296' : '74rem',
        '328' : '82rem',
      },
      margin: {
        '16' : '4.25rem',
        '17' : '4.5rem',
      },
    },
  },
  plugins: [],
};
