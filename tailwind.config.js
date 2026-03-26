/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Kita daftarkan palet warna premium kita di sini agar mudah dipanggil
        'navy-main': '#0F172A',
        'slate-card': '#1E293B',
        'gold-primary': '#FBBF24',
        'slate-text': '#94A3B8',
      },
    },
  },
  plugins: [],
}