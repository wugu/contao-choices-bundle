<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
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
     * @param FilterConfigElementContainer $filterConfigElementContainer
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
                'label'                   => &$GLOBALS['TL_LANG']['tl_filter_config_element']['addChoicesSupport'],
                'exclude'                 => true,
                'inputType'               => 'checkbox',
                'eval'                    => ['tl_class' => 'w50'],
                'sql'                     => "char(1) NOT NULL default ''"
            ],
            'skipChoicesSupport' => [
                'label'                   => &$GLOBALS['TL_LANG']['tl_filter_config_element']['skipChoicesSupport'],
                'exclude'                 => true,
                'inputType'               => 'checkbox',
                'eval'                    => ['tl_class' => 'w50'],
                'sql'                     => "char(1) NOT NULL default ''"
            ],
        ];

        $dca['fields'] = array_merge($fields, is_array($dca['fields']) ? $dca['fields'] : []);
    }
}