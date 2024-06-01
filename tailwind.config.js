/** @type {import('tailwindcss').Config} */
module.exports = {
  // content: ["./requirement/*.php"],
  // content: ["./*.{html,php}"],
  purge: [
    './requirement/*.php',
    './*.{html,php}',
  ],  
  theme: {
    extend: {},
  },
  plugins: [],
}

