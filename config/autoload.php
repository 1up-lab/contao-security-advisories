<?php

ClassLoader::addNamespaces([
    'Oneup',
    'Oneup\SecurityAdvisory'
]);

ClassLoader::addClasses([
    // Modules & Callbacks
    'Oneup\SecurityAdvisory\ModuleSecurityAdvisory' => 'system/modules/security-advisories/modules/ModuleSecurityAdvisory.php',
    'Oneup\SecurityAdvisory\SecurityCheck' => 'system/modules/security-advisories/classes/SecurityCheck.php',

    // Classes
    'Oneup\SecurityAdvisory\Audit' => 'system/modules/security-advisories/classes/Audit.php',
    'Oneup\SecurityAdvisory\AuditRunner' => 'system/modules/security-advisories/classes/AuditRunner.php'
]);


TemplateLoader::addFiles([
    'be_security_check' => 'system/modules/security-advisories/templates/backend'
]);