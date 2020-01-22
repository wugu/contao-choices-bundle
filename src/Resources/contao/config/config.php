<?php

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getAttributesFromDca']['choices'] = [\HeimrichHannot\ChoicesBundle\EventListener\GetAttributesFromDcaListener::class, 'onGetAttributesFromDca'];
$GLOBALS['TL_HOOKS']['loadDataContainer']['choices'] = [\HeimrichHannot\ChoicesBundle\EventListener\LoadDataContainerListener::class, 'onLoadDataContainer'];