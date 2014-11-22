<?php

ClassLoader::addNamespaces([
    'Oneup',
    'Oneup\SecurityAdvisory'
]);

ClassLoader::addClasses([
    // Modules
    'Oneup\SecurityAdvisory\ModuleSecurityAdvisory' => 'system/modules/security-advisories/modules/ModuleSecurityAdvisory.php',

    // Classes
    'Oneup\SecurityAdvisory\SecurityCheck' => 'system/modules/security-advisories/classes/SecurityCheck.php',
    'Oneup\SecurityAdvisory\CheckRunner' => 'system/modules/security-advisories/classes/CheckRunner.php',
    'Oneup\SecurityAdvisory\CheckParser' => 'system/modules/security-advisories/classes/CheckParser.php',
]);


TemplateLoader::addFiles([
    'be_security_check' => 'system/modules/security-advisories/templates/backend'
]);