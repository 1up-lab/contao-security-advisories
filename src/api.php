<?php

// Set the script name
define('TL_SCRIPT', 'audit.php');

// Initialize the system
define('TL_MODE', 'BE');

$possibleLockfiles[] = [
    '../../composer.lock',
    '../../../../../../../composer.lock',
    '../../../../../../composer.lock',
    $_SERVER['DOCUMENT_ROOT'] . '/composer.lock'
];

$possibleLockfiles[] = [
    '../../composer/composer.lock',
    '../../../../../../../composer/composer.lock',
    '../../../../../../composer/composer.lock',
    $_SERVER['DOCUMENT_ROOT'] . '/composer/composer.lock'
];


foreach ([
             '../../initialize.php',
             '../../../../../../../system/initialize.php',
             '../../../../../../system/initialize.php',
             $_SERVER['DOCUMENT_ROOT'] . '/system/initialize.php'
         ] as $script
) {
    if (file_exists($script)) {
        require_once($script);
        break;
    }
}

if($GLOBALS['TL_CONFIG']['securityAdvisory_enableAPI']) {
    if(isset($_SERVER['HTTP_AUTHORIZATION_TOKEN']) && $_SERVER['HTTP_AUTHORIZATION_TOKEN'] === $GLOBALS['TL_CONFIG']['securityAdvisory_APIKey']) {
        $foundFiles = [];

        foreach ($possibleLockfiles as $possibilities) {
            foreach ($possibilities as $checkPath) {
                if(file_exists($checkPath)) {
                    $foundFiles[] = $checkPath;
                    break;
                }
            }
        }

        if(count($foundFiles) > 0) {
            $contents = ['locks' => []];
            foreach ($foundFiles as $lockFile) {
                $contents['locks'][] = file_get_contents($lockFile);
            }

            echo json_encode($contents);
        } else {
            die('No composer.lock files found on server');
        }

    } else {
        die('No or incorrect authorization-token provided!');
    }

} else {
    die('API not enabled');
}
