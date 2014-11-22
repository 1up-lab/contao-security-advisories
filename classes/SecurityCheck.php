<?php

namespace Oneup\SecurityAdvisory;

use Contao\RequestToken;

class SecurityCheck extends \Backend implements \executable
{
    protected $auditCache;

    public function __construct()
    {
        parent::__construct();

        $this->auditCache = TL_ROOT . '/system/cache/security-audit.json';
    }

    public function run()
    {
        $objTemplate = new \BackendTemplate('be_security_check');

        $runner = $this->getCheckRunner();
        $parser = $this->getCheckParser();

        // Run the update
        if (\Input::post('run') != '') {
            // Perform an actual check against the web service and cache the result afterwards
            $response = $runner->run();
            $this->cacheAudit($response);
        } else {
            $response = $this->getCachedAudit();
        }

        $atLeastOneAuditPerformed = file_exists($this->auditCache);
        $objTemplate->atLeastOneAuditPerformed = $atLeastOneAuditPerformed;

        if ($atLeastOneAuditPerformed) {

            // Check if response is vulnerable
            $isVulnerable = $parser->isVulnerable($response);
            $objTemplate->isVulnerable = $isVulnerable;

            $objTemplate->vulnerabilityFound = $GLOBALS['TL_LANG']['tl_security_advisory']['vulnerabilityFound'];
            $objTemplate->noVulnerabilityFound = $GLOBALS['TL_LANG']['tl_security_advisory']['noVulnerabilityFound'];
            $objTemplate->lastChecked = \Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], filemtime($this->auditCache));
        }

        // Language string
        $objTemplate->headline = $GLOBALS['TL_LANG']['tl_security_advisory']['headline'];
        $objTemplate->runSecurityCheck = $GLOBALS['TL_LANG']['tl_security_advisory']['runSecurityCheck'];
        $objTemplate->requestToken = RequestToken::get();

        return $objTemplate->parse();
    }

    public function isActive()
    {
        return false;
    }

    protected function cacheAudit($response)
    {
        file_put_contents($this->auditCache, $response);
    }

    protected function getCachedAudit()
    {
        if (file_exists($this->auditCache)) {
            return file_get_contents($this->auditCache);
        }

        return '[]';
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