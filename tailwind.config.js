/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors:{
        halfBlack:"#141414",
        pastelBlue:"#798AFC",
        greyWhite:"#F9F9F9",
      }
    },
  },
  plugins: [require('flowbite/plugin')],
}



