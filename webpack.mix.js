const { mix } = require('laravel-mix');
const path = require('path');

// mix.config.versioning.enabled = true;

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/admin.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');


mix.webpackConfig({
  resolve: {
    extensions: ['*', '.js', '.jsx', '.vue'],
    alias: {
      'vue$': 'vue/dist/vue.common.js',
      'src': 'assets/js/',
      'plugins': 'assets/js/plugins/',
      'utils': 'assets/js/utils/',
      'app': 'assets/js/frontend/',
      'home': 'assets/js/frontend/components/',
    },
    modules: [
      'node_modules',
      path.resolve(__dirname, "resources")
    ]
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        loader: 'style-loader!css-loader'
      }
    ]
  }
});
