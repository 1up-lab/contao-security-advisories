<?php

namespace Oneup\SecurityAdvisory\Listener;

use Oneup\SecurityAdvisory\Audit\Audit;

class LogListener
{
    public function onSecurityAudit(Audit $audit)
    {
        \System::log('A security audit was performed. Number of issues: '.count($audit->getVulnerabilities()), 'LogListener::onSecurityAudit', $audit->isVulnerable() ? 'ERROR' : 'CRON');
    }
}
