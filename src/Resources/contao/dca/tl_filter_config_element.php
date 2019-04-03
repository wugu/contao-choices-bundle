<?php

if (\Contao\System::getContainer()->get('huh.utils.container')->isBundleActive('HeimrichHannot\FilterBundle\HeimrichHannotContaoFilterBundle'))
{
    $dca = &$GLOBALS['TL_DCA']['tl_filter_config_element'];

    /**
     * Palettes
     */
    \Contao\System::getContainer()->get('huh.choices.data_container.filter_config_element_container')->addChoicesFieldToTypePalettes($dca);

    /**
     * Fields
     */
    $dca['fields'] += [
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
}