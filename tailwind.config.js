/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
  extend: {
    fontFamily: {
      display: ['Playfair Display', 'serif'],
      sans: ['Inter', 'system-ui', 'sans-serif'],
    },
    colors: {
      tinta: "#111111",
      crema: "#FAFAF7",
      gris: "#6B7280",
      borde: "#E5E7EB",
      acento: "#111827"
    },
    boxShadow: {
      suave: "0 10px 30px rgba(0,0,0,.07)",
    },
    borderRadius: {
      xl2: "1.25rem",
    },
  },
},
  plugins: [],
};
