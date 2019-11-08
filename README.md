# Contao Choices Bundle

This bundle offers support for the JavaScript library [Choices](https://github.com/jshjohnson/Choices) for the Contao CMS.

## Features

- activate choices support on page level (with inheritance and override option)
- adds the data attributes necessary for the library using the `getAttributesFromDca` hook (when activated for page)
- [Encore Bundle](https://github.com/heimrichhannot/contao-encore-bundle) support
- [Filter Bundle](https://github.com/heimrichhannot/contao-filter-bundle) support


## Setup

1. Install via composer: `composer require heimrichhannot/contao-choices-bundle`.
1. Update Database
1. Encore Bundle: Prepare and generate encore entries

## Usage

Active or deactivate choices support on page level (Layout section). You can activate/deactivate it separately for select and text boxes. You can overwrite settings from a parent page.

### Filter Bundle

Choices.js support it automatically added to choice type form fields. It can be disabled in the type configuration. For other config types it can be activated in the configuration.

## Developers

### Assets

Bundle assets are provided as [yarn package](https://yarn.pm/@hundh/contao-choices-bundle). Sources and JavaScript documentation can be found in [`src/Resources/npm-package`](https://github.com/heimrichhannot/contao-choices-bundle/tree/master/src/Resources/npm-package).

### Custom usage
If you use the library in a different way than this bundle provides (e.g. a custom module), use the frontend asset service to dynamically add the frontend assets. 

```php
/** @var Symfony\Component\DependencyInjection\ContainerInterface $container **/
$container->get(FrontendAsset::class)->addFrontendAssets();
```

