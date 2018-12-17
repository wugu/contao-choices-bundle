<?php

$dca = &$GLOBALS['TL_DCA']['tl_filter_config_element'];

/**
 * Palettes
 */
System::getContainer()->get('huh.choices.event_listener.data_container.filter_config_element_listener')->addChoicesFieldToTypePalettes($dca);

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