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
1. You can now activate Choices for select and text inputs in root page settings (Layout Settings) and override the settings in child pages.
1. If you use Encore Bundle: Add and activate `contao-choices-bundle` and `contao-choices-bundle-theme` on root page or the pages, where you want to use it.