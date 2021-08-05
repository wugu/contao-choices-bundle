<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ChoicesBundle\Manager;

use Contao\Controller;

class ChoicesManager
{
    public function getOptionsFromDca(string $table, string $field): array
    {
        Controller::loadDataContainer($table);
        $options = [];
        $dca = &$GLOBALS['TL_DCA'][$table];

        if (isset($dca['fields'][$field]['eval']['choicesOptions']) && \is_array($dca['fields'][$field]['eval']['choicesOptions'])) {
            $options = $dca['fields'][$field]['eval']['choicesOptions'];
        }

        return $options;
    }

    public function getOptionsAsArray(array $customOptions = [], string $table = '', string $field = ''): array
    {
        $options = $this->getDefaultOptions();

        if (!empty($table) && empty($field)) {
            $options = array_merge($options, $this->getOptionsFromDca($table, $field));
        }
        $options = array_merge($options, $customOptions);

        return $options;
    }

    public function getDefaultOptions(): array
    {
        return [
            'loadingText' => $GLOBALS['TL_LANG']['MSC']['choices.js']['loadingText'],
            'noResultsText' => $GLOBALS['TL_LANG']['MSC']['choices.js']['noResultsText'],
            'noChoicesText' => $GLOBALS['TL_LANG']['MSC']['choices.js']['noChoicesText'],
            'itemSelectText' => $GLOBALS['TL_LANG']['MSC']['choices.js']['itemSelectText'],
            'addItemTextString' => $GLOBALS['TL_LANG']['MSC']['choices.js']['addItemText'],
            'maxItemTextString' => $GLOBALS['TL_LANG']['MSC']['choices.js']['maxItemText'],
            'shouldSort' => false,
        ];
    }
}
