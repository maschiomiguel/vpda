import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Restrita
                "resources/restrita/js/dashboard.js",
                "resources/restrita/sass/main.scss",

                // Site

                // SASS
                "resources/front/sass/main.scss",
                "resources/front/sass/vendors/bootstrap/bootstrap.scss",

                // JS
                // "resources/front/js/vendors/jquery.mask.min.js",  // Necessario ajustar o type module (não funciona)
                "resources/front/js/vendors/bootstrap.bundle.min.js",
                "resources/front/js/main.js",
            ],
            refresh: true,
        }),
    ],
});
