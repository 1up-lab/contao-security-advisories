<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace('defaultChmod;', 'defaultChmod;{securityAdvisory_legend:hide},securityAdvisory_enableCron;', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);

// Register subpalettes
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'securityAdvisory_enableCron';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes'] += array
(
    'securityAdvisory_enableCron' => 'securityAdvisory_cronCycle'
);

$GLOBALS['TL_DCA']['tl_settings']['fields'] += array(
    'securityAdvisory_enableCron' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['securityAdvisory_enableCron'],
        'exclude'                 => true,
        'filter'                  => true,
        'inputType'               => 'checkbox',
        'eval'                    => array('submitOnChange'=>true),
        'sql'                     => "char(1) NOT NULL default ''"
    ),
    'securityAdvisory_cronCycle' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_settings']['securityAdvisory_cronCycle'],
        'default'       => $type,
        'inputType'     => 'select',
        'filter'        => true,
        'options'       => array_keys($GLOBALS['TL_CRON']),
        'reference'     => &$GLOBALS['TL_LANG']['tl_settings'],
        'eval'          => array('includeBlankOption'=> false,
            'submitOnChange'    => false,
            'tl_class'          => 'w50'),
        'sql'           => "varchar(32) NOT NULL default ''"
    ),
);