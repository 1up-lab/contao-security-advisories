<?php

ClassLoader::addNamespaces([
    'Oneup',
    'Oneup\SecurityAdvisory',
    'Oneup\SecurityAdvisory\Listener'
]);

ClassLoader::addClasses([
    // Modules & Callbacks
    'Oneup\SecurityAdvisory\ModuleSecurityAdvisory' => 'system/modules/security-advisories/modules/ModuleSecurityAdvisory.php',
    'Oneup\SecurityAdvisory\SecurityCheck' => 'system/modules/security-advisories/classes/SecurityCheck.php',

    // Classes
    'Oneup\SecurityAdvisory\Audit' => 'system/modules/security-advisories/classes/Audit.php',
    'Oneup\SecurityAdvisory\AuditCronJob' => 'system/modules/security-advisories/AuditCronJob.php',
    'Oneup\SecurityAdvisory\AuditRunner' => 'system/modules/security-advisories/classes/AuditRunner.php',

    // Listeners
    'Oneup\SecurityAdvisory\Listener\LogListener' => 'system/modules/security-advisories/listeners/LogListener.php',
    'Oneup\SecurityAdvisory\Listener\NotificationListener' => 'system/modules/security-advisories/listeners/NotificationListener.php',

]);


TemplateLoader::addFiles([
    'be_security_check' => 'system/modules/security-advisories/templates/backend'
]);