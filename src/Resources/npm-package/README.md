# Contao Choices Bundle Assets

This package contains the frontend assets of the composer bundle heimrichhannot/contao-choices-bundle.

## Install

Typicall this package comes with [Contao Choices Bundle](https://github.com/heimrichhannot/contao-choices-bundle). If you want to install it by yourself: 

```npm
yarn add @hundh/contao-choices-bundle
```

## Usage

If you want to use the bundle independent of Choices Bundle: 

```js
import ChoicesBundle from '@hundh/contao-choices-bundle'

ChoicesBundle.init();
```

Choices.js will be added to all select and text fields with attribute `data-choices=1`.

### Options
You can pass options to Choices constructor by adding them json_encoded to `data-choices-options` attribute.

### Translations
Translations can be passed as options to Choices. For callback translation (`addItemText`, `maxItemText`) two additional options added: `addItemTextString` and `maxItemTextString`.


## API

### init

Apply a choice instance to all inputs with attribute `data-choices=1`. 
You can pass additional options as json string in `data-choices-options` attribute.

### getChoiceInstances

Returns an array of objects containing element and choice instance.

```
[{element: HTMLElement, instance: ChoiceInstance},...]
```

