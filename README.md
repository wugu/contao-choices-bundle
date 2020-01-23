# Contao Choices Bundle

This bundle offers support for the JavaScript library [Choices.js](https://github.com/jshjohnson/Choices) for the Contao CMS.

## Features

- activate choices support on page level (with inheritance and override option)
- customize options from dca or dynamically from event
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

### PHP Events

To customize options passed to the choices.js library, you can use the `CustomizeChoicesOptionsEvent`. Register an event listener to `huh.choices.customize_choices_options`. This work for 'normal' widgets and filter bundle fields. In your event listener you check, if the event comes from an filter bundle field by calling `CustomizeChoicesOptionsEvent::isFilterField(): bool`. In this case, the complete (but cloned) `AdjustFilterOptionsEvent` is passed to the event and the fieldAttributes array is empty. If you don't use filter bundle, you can ignore the filter bundle part.

```yaml
  HeimrichHannot\CustomBundle\EventListener\CustomizeChoicesOptionsListener:
    tags:
      - { name: kernel.event_listener, event: huh.choices.customize_choices_options }
```

```php
namespace HeimrichHannot\CustomBundle\EventListener\CustomizeChoicesOptionsListener;

class CustomizeChoicesOptionsListener
{
    public function onHuhChoicesCustomizeChoicesOptions(\HeimrichHannot\TrafficLinesBundle\EventListener\CustomizeChoicesOptionsEvent $event)
    {
        if ($event->isFilterField()) {
            $this->addFilterChoicesOptions($event);
        } else {
            $this->addFieldChoicesOptions($event);
        }       
    }
       
}
```

### JavaScript Events

Following events can be used to further customize the choices instances: 

Event name | Data | Description
---------- | ---- | -----------
hundhChoicesOptions | options | Customize options before instantiating the choice object.
hundhChoicesNewInstance | instance | Is dispatched right after the choices instance is create.

Example:

```javascript
/**
 * @param { CustomEvent } event
 */
function onHundhChoicesOptions(event) {
    let options = event.detail.options;
    // Customize options
}

/**
 * @param { CustomEvent } event
 */
function onHundhChoicesNewInstance(event) {
    let choicesInstance = event.detail.instance;
    // Work with the choices instance
}

document.addEventListener('hundhChoicesOptions', onHundhChoicesOptions);
document.addEventListener('hundhChoicesNewInstance', onHundhChoicesNewInstance);

```

### Assets

Bundle assets are provided as [yarn package](https://yarn.pm/@hundh/contao-choices-bundle). Sources and JavaScript documentation can be found in [`src/Resources/npm-package`](https://github.com/heimrichhannot/contao-choices-bundle/tree/master/src/Resources/npm-package).

### Custom usage
If you use the library in a different way than this bundle provides (e.g. a custom module), use the frontend asset service to dynamically add the frontend assets. 

```php
/** @var Symfony\Component\DependencyInjection\ContainerInterface $container **/
$container->get(FrontendAsset::class)->addFrontendAssets();
```

