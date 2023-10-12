/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [],
    theme: {
      extend: {},
    },
    plugins: [],
  }

  /** @type {import('tailwindcss').Config} */
  module.exports = {
      important: true,
        content: ["./**/*.{html,js,php}"],
        daisyui: {
            themes: ['light'],
            base: false,
            prefix: "",
            logs: false,
        },
        theme: {},
        plugins: [require("daisyui")],
        prefix: 'spapi-',
        corePlugins: {
        preflight: false,
    },
  }
