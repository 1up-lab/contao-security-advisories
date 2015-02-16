<?php

namespace Oneup\SecurityAdvisory\Listener;

use Oneup\SecurityAdvisory\Audit\Audit;

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

        if ($onlyFailed && !$audit->isVulnerable()) {
            return;
        }

        // Load language file
        \System::loadLanguageFile('tl_security_advisory');

        $address = strlen($notifiactionMail) > 0 ? $notifiactionMail : $administratorMail;

        $objEmail= new \Email();
        $objEmail->from = $GLOBALS['TL_ADMIN_EMAIL'];
        $objEmail->fromName = $GLOBALS['TL_ADMIN_NAME'];
        $objEmail->subject = sprintf($GLOBALS['TL_LANG']['tl_security_advisory'][$audit->isVulnerable() ? 'mail_subject_failed' : 'mail_subject_ok'], \Idna::decode(\Environment::get('host')));

        $objTemplate = new \FrontendTemplate('notification_mail');
        $objTemplate->headline = $GLOBALS['TL_LANG']['tl_security_advisory']['mail_headline'];
        $objTemplate->bodyOk = sprintf($GLOBALS['TL_LANG']['tl_security_advisory']['mail_body_ok'], \Idna::decode(\Environment::get('host')));
        $objTemplate->bodyFailed = sprintf($GLOBALS['TL_LANG']['tl_security_advisory']['mail_body_failed'], \Idna::decode(\Environment::get('host')));

        $objTemplate->isVulnerable = $audit->isVulnerable();
        $objTemplate->vulnerabilites = $audit->getVulnerabilities();

        // Set template as text mail body.
        $objEmail->text = $objTemplate->parse();

        $objEmail->sendTo($address);
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
