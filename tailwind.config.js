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
      tinta:  "#1A1A18",
      crema:  "#F6F4F1",
      gris:   "#716F6A",
      borde:  "#E2DED9",
      acento: "#1A1A18",
      moda:   "#B8936A",
      oferta: "#9B1D3A",
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
