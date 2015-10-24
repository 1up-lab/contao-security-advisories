<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace('defaultChmod;', 'defaultChmod;{securityAdvisory_legend:hide},securityAdvisory_enableCron,securityAdvisory_enableNotifications;', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);

// Register subpalettes
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'securityAdvisory_enableCron';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'securityAdvisory_enableNotifications';

$GLOBALS['TL_DCA']['tl_settings']['subpalettes'] = $GLOBALS['TL_DCA']['tl_settings']['subpalettes'] ?: [];
$GLOBALS['TL_DCA']['tl_settings']['subpalettes'] += [
    'securityAdvisory_enableCron' => 'securityAdvisory_cronCycle'
];

$GLOBALS['TL_DCA']['tl_settings']['subpalettes'] += [
    'securityAdvisory_enableNotifications' => 'securityAdvisory_notificationMail,securityAdvisory_suppressManualAuditNotification,securityAdvisory_onlyFailedNotifications'
];

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
    'securityAdvisory_enableNotifications' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['securityAdvisory_enableNotifications'],
        'exclude'                 => true,
        'filter'                  => true,
        'inputType'               => 'checkbox',
        'eval'                    => array('submitOnChange'=>true),
        'sql'                     => "char(1) NOT NULL default ''"
    ),
    'securityAdvisory_suppressManualAuditNotification' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['securityAdvisory_suppressManualAuditNotification'],
        'exclude'                 => true,
        'filter'                  => true,
        'inputType'               => 'checkbox',
        'eval'                    => array('submitOnChange'=>false, 'tl_class'=>'w50'),
        'sql'                     => "char(1) NOT NULL default ''"
    ),
    'securityAdvisory_onlyFailedNotifications' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['securityAdvisory_onlyFailedNotifications'],
        'exclude'                 => true,
        'filter'                  => true,
        'inputType'               => 'checkbox',
        'eval'                    => array('submitOnChange'=>false, 'tl_class'=>'w50'),
        'sql'                     => "char(1) NOT NULL default ''"
    ),
    'securityAdvisory_notificationMail' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['securityAdvisory_notificationMail'],
        'inputType'               => 'text',
        'eval'                    => array('rgxp'=>'friendly', 'decodeEntities'=>true)
    ),
    'securityAdvisory_cronCycle' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_settings']['securityAdvisory_cronCycle'],
        'default'       => $type,
        'inputType'     => 'select',
        'filter'        => true,
        'options'       => array_keys($GLOBALS['TL_CRON']),
        'reference'     => &$GLOBALS['TL_LANG']['tl_settings'],
        'eval'          => array('includeBlankOption'=> false, 'submitOnChange' => false, 'mandatory' => true),
        'sql'           => "varchar(32) NOT NULL default ''"
    ),
);
