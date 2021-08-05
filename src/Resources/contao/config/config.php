<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

use HeimrichHannot\ChoicesBundle\EventListener\GetAttributesFromDcaListener;
use HeimrichHannot\ChoicesBundle\EventListener\LoadDataContainerListener;

$GLOBALS['TL_HOOKS']['getAttributesFromDca']['choices'] = [GetAttributesFromDcaListener::class, 'onGetAttributesFromDca'];
$GLOBALS['TL_HOOKS']['loadDataContainer']['choices'] = [LoadDataContainerListener::class, 'onLoadDataContainer'];
