import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            //  COLORES CORPORATIVOS
            colors: {
                brand: {
                    teal: "#00747C" /* Teal Principal */,
                    light: "#00BBC9" /* Teal Claro (Acentos) */,
                    graylight: "#CACACA" /* Gris Claro */,
                    graymed: "#878787" /* Gris Medio */,
                    graydark: "#202022" /* Gris Oscuro */,
                },
            },
        },
    },

    plugins: [forms],
};
