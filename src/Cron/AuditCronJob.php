<?php

namespace Oneup\SecurityAdvisory\Cron;

use Oneup\SecurityAdvisory\Audit\AuditRunner;

class AuditCronJob
{
    public function run()
    {
        $auditRunner = new AuditRunner();
        $auditRunner->addLockFile(TL_ROOT.'/composer/composer.lock');

        if (file_exists(TL_ROOT.'/composer.lock')) {
            $auditRunner->addLockFile(TL_ROOT.'/composer.lock');
        }

        $auditRunner->run();
    }
}
