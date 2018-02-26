var Encore = require('@symfony/webpack-encore');
var LiveReloadPlugin = require('webpack-livereload-plugin');
var Dotenv = require('dotenv-webpack');

Encore
    .addPlugin(new LiveReloadPlugin())
    .addPlugin(new Dotenv({
        path: './.env'
    }))

    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // core styling
    .addStyleEntry('core/css/omed', './public/bundles/omedcore/css/style.scss')

    // React Frontend
    .addEntry('react/js/omed-react','./public/bundles/omedreact/js/index.js')
    .enableReactPreset()

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
