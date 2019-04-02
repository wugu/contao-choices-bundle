var Encore = require('@symfony/webpack-encore');

Encore
.setOutputPath('src/Resources/public/js/')
.addEntry('contao-choices-bundle', './src/Resources/assets/js/contao-choices-bundle.js')
.setPublicPath('/public/js/')
.disableSingleRuntimeChunk()
.addExternals({
    'choices.js': 'Choices'
})
.configureBabel(function (babelConfig) {
}, {
    // include to babel processing
    includeNodeModules: ['@hundh/contao-choices-bundle']
})
.enableSourceMaps(!Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();