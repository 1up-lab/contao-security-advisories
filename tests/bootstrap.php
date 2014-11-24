<?php
/**
 * Description needed here.
 *
 * PHP version 5
 * @package    Oneup/SecurityAdvisories
 * @subpackage Tests
 * @author     David Greminger <david.greminger@1up.io>
 * @copyright  1up GmbH.
 * @license    MIT.
 * @filesource
 */

error_reporting(E_ALL);

function includeIfExists($file)
{
    return file_exists($file) ? include $file : false;
}

if (
    // Locally installed dependencies
    (!$loader = includeIfExists(__DIR__.'/../vendor/autoload.php'))
    // We are within an composer install.
    && (!$loader = includeIfExists(__DIR__.'/../../../autoload.php'))) {
    echo 'You must set up the project dependencies, run the following commands:'.PHP_EOL.
        'curl -sS https://getcomposer.org/installer | php'.PHP_EOL.
        'php composer.phar install'.PHP_EOL;
    exit(1);
}
