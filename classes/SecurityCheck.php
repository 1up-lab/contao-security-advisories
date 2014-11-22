<?php

namespace Oneup\SecurityAdvisory;

use Contao\RequestToken;

class SecurityCheck extends \Backend implements \executable
{
    public function isActive()
    {
        return false;
    }

    public function run()
    {
        $objTemplate = new \BackendTemplate('be_security_check');
        $objTemplate->checkPerformed = false;

        // Run the update
        if (\Input::post('run') != '') {
            $runner = $this->getCheckRunner();
            $parser = $this->getCheckParser();

            $response = $runner->run();

            $isVulnerable = $parser->isVulnerable($response);

            $objTemplate->checkPerformed = true;
            $objTemplate->isVulnerable = $isVulnerable;
        }

        $objTemplate->lastChecked = \Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], filemtime(TL_ROOT . '/system/cache/security-audit.json'));

        // Language string
        $objTemplate->vulnerabilityFound = $GLOBALS['TL_LANG']['tl_security_advisory']['vulnerabilityFound'];
        $objTemplate->noVulnerabilityFound = $GLOBALS['TL_LANG']['tl_security_advisory']['noVulnerabilityFound'];
        $objTemplate->headline = $GLOBALS['TL_LANG']['tl_security_advisory']['headline'];
        $objTemplate->runSecurityCheck = $GLOBALS['TL_LANG']['tl_security_advisory']['runSecurityCheck'];
        $objTemplate->requestToken = RequestToken::get();

        return $objTemplate->parse();
    }

    protected function getCheckRunner()
    {
        return new CheckRunner();
    }

    protected function getCheckParser()
    {
        return new CheckParser();
    }
}