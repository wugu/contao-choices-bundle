<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ChoicesBundle\Manager;

use Contao\CoreBundle\Framework\FrameworkAwareInterface;
use Contao\CoreBundle\Framework\FrameworkAwareTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ChoicesManager
{
    public function getOptionsAsArray(array $customOptions = [])
    {
        $defaultOptions = [
            'loadingText'    => $GLOBALS['TL_LANG']['MSC']['choices.js']['loadingText'],
            'noResultsText'  => $GLOBALS['TL_LANG']['MSC']['choices.js']['noResultsText'],
            'noChoicesText'  => $GLOBALS['TL_LANG']['MSC']['choices.js']['noChoicesText'],
            'itemSelectText' => '',
            'shouldSort'     => false,
        ];

        $options = array_merge($defaultOptions, $customOptions);

        return $options;
    }
}