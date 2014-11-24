<?php

namespace Oneup\SecurityAdvisory\Check;

use Contao\RequestToken;
use Oneup\SecurityAdvisory\Audit\AuditRunner;

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

        if ($auditRunner->hasRunOnce()) {
            $objTemplate->lastChecked = \Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $auditRunner->getCacheLastModified());
        }

        // Language string
        $objTemplate->headline = $GLOBALS['TL_LANG']['tl_security_advisory']['headline'];
        $objTemplate->disclaimer = $GLOBALS['TL_LANG']['tl_security_advisory']['disclaimer'];
        $objTemplate->runSecurityCheck = $GLOBALS['TL_LANG']['tl_security_advisory']['runSecurityCheck'];
        $objTemplate->auditOk = $GLOBALS['TL_LANG']['tl_security_advisory']['auditOk'];
        $objTemplate->noAuditFound = $GLOBALS['TL_LANG']['tl_security_advisory']['auditNotFound'];
        $objTemplate->auditFailed = $GLOBALS['TL_LANG']['tl_security_advisory']['auditFailed'];
        $objTemplate->lastCheckedLabel = $GLOBALS['TL_LANG']['tl_security_advisory']['lastCheckedLabel'];
        $objTemplate->requestToken = RequestToken::get();
        $objTemplate->didNeverAnAudit = $GLOBALS['TL_LANG']['tl_security_advisory']['didNeverAnAudit'];

        return $objTemplate->parse();
    }

    public function isActive()
    {
        return false;
    }
}
