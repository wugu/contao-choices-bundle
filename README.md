# Contao Choices Bundle

This bundle offers support for the JavaScript library [Choices](https://github.com/jshjohnson/Choices) for the Contao CMS.

## Features

- activate choosen support on page level (with inheritance and override option)
- adds the data attributes necessary for the library using the `getAttributesFromDca` hook (when activated for page)
- [Encore Bundle](https://github.com/heimrichhannot/contao-encore-bundle) support
- [Filter Bundle](https://github.com/heimrichhannot/contao-filter-bundle) support


## Setup

1. Install via composer: `composer require heimrichhannot/contao-choices-bundle`.
1. Update Database
1. Encore Bundle: Prepare and generate encore entries
1. You can now activate Choices for select and text inputs in root page settings (Layout Settings) and override the settings in child pages.

## Developers

### Assets

Bundle assets are provided as [yarn package](https://yarn.pm/@hundh/contao-choices-bundle). Sources and JavaScript documentation can be found in [`src/Resources/npm-package`](https://github.com/heimrichhannot/contao-choices-bundle/tree/master/src/Resources/npm-package).

### Custom usage
If you use the library in a different way than this bundle provides (e.g. a custom module), use the frontend asset service to dynamically add the frontend assets. 

```php
/** @var Symfony\Component\DependencyInjection\ContainerInterface $container **/
$container->get(FrontendAsset::class)->addFrontendAssets();
```

