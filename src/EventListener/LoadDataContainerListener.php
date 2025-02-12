<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\ChoicesBundle\EventListener;

use HeimrichHannot\ChoicesBundle\DataContainer\FilterConfigElementContainer;

class LoadDataContainerListener
{
    /**
     * @var FilterConfigElementContainer
     */
    private $filterConfigElementContainer;

    /**
     * LoadDataContainerListener constructor.
     */
    public function __construct(FilterConfigElementContainer $filterConfigElementContainer)
    {
        $this->filterConfigElementContainer = $filterConfigElementContainer;
    }

    public function onLoadDataContainer(string $table)
    {
        switch ($table) {
            case 'tl_filter_config_element':
                $this->addFilterConfigDcaFields();

                return;
        }
    }

    protected function addFilterConfigDcaFields()
    {
        $dca = &$GLOBALS['TL_DCA']['tl_filter_config_element'];

        $this->filterConfigElementContainer->addChoicesFieldToTypePalettes($dca);

        $fields = [
            'addChoicesSupport' => [
                'label' => &$GLOBALS['TL_LANG']['tl_filter_config_element']['addChoicesSupport'],
                'exclude' => true,
                'inputType' => 'checkbox',
                'eval' => ['tl_class' => 'w50'],
                'sql' => "char(1) NOT NULL default ''",
            ],
            'skipChoicesSupport' => [
                'label' => &$GLOBALS['TL_LANG']['tl_filter_config_element']['skipChoicesSupport'],
                'exclude' => true,
                'inputType' => 'checkbox',
                'eval' => ['tl_class' => 'w50'],
                'sql' => "char(1) NOT NULL default ''",
            ],
        ];

        $dca['fields'] = array_merge($fields, \is_array($dca['fields']) ? $dca['fields'] : []);
    }
}
