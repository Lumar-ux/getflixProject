/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.php", "./*.php", "./node_modules/flowbite/**/*.js"],
  theme: {
    extend: {
      colors: {
        halfBlack: "#141414",
        pastelBlue: "#798AFC",
        greyWhite: "#F9F9F9",
        coloHover: "#424242",
      },
    },
  },
  plugins: [require("flowbite/plugin")],
};
