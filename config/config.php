<?php

$GLOBALS['TL_CSS'][] = 'system/modules/security-advisories/assets/css/security-advisories.css';

$GLOBALS['BE_MOD']['system']['security_advisory'] = [
    'callback' => 'Oneup\SecurityAdvisory\ModuleSecurityAdvisory'
];

$GLOBALS['TL_SECURITY_ADVISORY'] = ['Oneup\SecurityAdvisory\SecurityCheck'];


// Enable cron if necessary
if (isset($GLOBALS['TL_CONFIG']['securityAdvisory_enableCron']) && true === $GLOBALS['TL_CONFIG']['securityAdvisory_enableCron']) {
    $GLOBALS['TL_CRON'][$GLOBALS['TL_CONFIG']['securityAdvisory_cronCycle']][] = array('AuditCronJob', 'run');
}