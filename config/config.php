<?php

$GLOBALS['BE_MOD']['system']['security_advisory'] = [
    'callback' => 'Oneup\SecurityAdvisory\ModuleSecurityAdvisory'
];

$GLOBALS['TL_SECURITY_ADVISORY'] = array
(
    'Oneup\SecurityAdvisory\SecurityCheck'
);