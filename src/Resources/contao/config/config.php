<?php

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getAttributesFromDca']['choices'] = [\HeimrichHannot\ChoicesBundle\EventListener\HookListener::class, 'onGetAttributesFromDca'];
$GLOBALS['TL_HOOKS']['getAttributesFromDca']['choices'] = [\HeimrichHannot\ChoicesBundle\EventListener\LoadDataContainerListener::class, 'onLoadDataContainer'];