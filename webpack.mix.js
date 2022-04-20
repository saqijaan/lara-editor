const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | All JS will be bundled into one file (see bundle.js).
 |
 | (this will also publish the assets for you to test, so no need to do that too)
 */

// merge all needed JS into a big bundle file
mix.js('src/resources/js', 'dist/assets/editor.js')
    .vue()
    .sass('src/resources/scss/gjs.scss','dist/assets/editor.css')
    .options({
        processCssUrls: false
    });

mix.copyDirectory('node_modules/grapesjs/dist/fonts', 'dist/fonts')
mix.copyDirectory('src/resources/js/plugins/image-editor/src/svg', 'dist/svg')
