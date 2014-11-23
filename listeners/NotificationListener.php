<?php

namespace Oneup\SecurityAdvisory\Listener;

use Oneup\SecurityAdvisory\Audit;

class NotificationListener
{
    public function onSecurityAudit(Audit $audit)
    {
        $enabled              = (bool) $GLOBALS['TL_CONFIG']['securityAdvisory_enableNotifications'];
        $suppressManualAudits = (bool) $GLOBALS['TL_CONFIG']['securityAdvisory_suppressManualAuditNotification'];
        $onlyFailed           = (bool) $GLOBALS['TL_CONFIG']['securityAdvisory_onlyFailedNotifications'];
        $notifiactionMail     =        $GLOBALS['TL_CONFIG']['securityAdvisory_notificationMail'];
        $administratorMail    =        $GLOBALS['TL_CONFIG']['adminEmail'];

        if (!$enabled) {
            return;
        }

        if (!$this->isCron() && $suppressManualAudits) {
            return;
        }

        if ($onlyFailed && $audit->isVulnerable()) {
            return;
        }

        $address = strlen($notifiactionMail) > 0 ? $notifiactionMail : $administratorMail;

        // Todo: Send E-Mail
    }

    /**
     * Returns false if the action was triggered manually.
     *
     * @todo This is a quite bad hack. Is there another way, anyone?
     * @return bool
     */
    protected function isCron()
    {
        return TL_MODE === 'FE';
    }
}