<?php

namespace Oneup\SecurityAdvisory;

use Contao\RequestToken;

class SecurityCheck extends \Backend implements \executable
{
    protected $auditCache;

    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        $objTemplate = new \BackendTemplate('be_security_check');

        $auditRunner = new AuditRunner();
        $auditRunner->addLockFile(TL_ROOT . '/composer/composer.lock');

        // Init Audit.
        $audit = null;

        if ($auditRunner->hasRunOnce()) {
            $audit = $auditRunner->getCachedAudit();
        }

        if (\Input::post('run') != '') {
            // Perform an actual check against the web service and cache the result afterwards
            $audit = $auditRunner->run();
        }

        if (null !== $audit) {
            $objTemplate->isVulnerable = $audit->isVulnerable();
            $objTemplate->vulnerabilities = $audit->getVulnerabilities();
        }

        $objTemplate->hasRunOnce = $auditRunner->hasRunOnce();

        $objTemplate->vulnerabilityFound = $GLOBALS['TL_LANG']['tl_security_advisory']['vulnerabilityFound'];
        $objTemplate->noVulnerabilityFound = $GLOBALS['TL_LANG']['tl_security_advisory']['noVulnerabilityFound'];

        if ($auditRunner->hasRunOnce()) {
            $objTemplate->lastChecked = \Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $auditRunner->getCacheLastModified());
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
}