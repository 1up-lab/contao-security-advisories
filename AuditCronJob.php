<?php

namespace Oneup\SecurityAdvisory;

class AuditCronJob
{
    public function run()
    {
        $auditRunner = new AuditRunner();
        $auditRunner->addLockFile(TL_ROOT . '/composer/composer.lock');
        $auditRunner->run();
    }
}