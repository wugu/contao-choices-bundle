var Encore = require('@symfony/webpack-encore');

Encore
.setOutputPath('src/Resources/public/assets')
.setPublicPath('/bundles/heimrichhannotcontaochoices/assets/')
.setManifestKeyPrefix('bundles/heimrichhannotcontaochoices/assets')
.addEntry('contao-choices-bundle', './src/Resources/assets/js/contao-choices-bundle.js')
.addEntry('contao-choices-bundle-theme', './src/Resources/assets/js/contao-choices-bundle-theme.js')
.disableSingleRuntimeChunk()
.splitEntryChunks()
.configureSplitChunks(function(splitChunks) {
    splitChunks.name =  function (module, chunks, cacheGroupKey) {
        const moduleFileName = module.identifier().split('/').reduceRight(item => item).split('.').slice(0, -1).join('.');
        return `${moduleFileName}`;
    };
})
.configureBabel(null)
.enableSourceMaps(!Encore.isProduction())
.enableSassLoader()
.enablePostCssLoader()
;

module.exports = Encore.getWebpackConfig();