<?php

namespace Oneup\SecurityAdvisory;

use GuzzleHttp\Client;

class AuditRunner
{
    protected $lockFiles;
    protected $auditCache;
    protected $guzzle;

    public function __construct()
    {
        $this->lockFiles = [];
        $this->auditCache = TL_ROOT . '/system/cache/security-audit.ser';
        $this->guzzle = new Client();
    }

    public function run()
    {
        $audit = new Audit();

        foreach ($this->lockFiles as $lockFile) {
            $request = $this->guzzle->createRequest('POST', 'https://security.sensiolabs.org/check_lock', [
                'headers' => ['Accept' => 'application/json'],
                'body' => ['lock' => fopen($lockFile, 'r')]
            ]);

            // get actual response body
            $responseBody = $this->guzzle->send($request)->getBody()->getContents();

            // add body to audit
            $audit->addResponse($responseBody);
        }

        $this->cacheAudit($audit);

        return $audit;
    }

    public function hasRunOnce()
    {
        return file_exists($this->auditCache);
    }

    public function cacheAudit(Audit $audit)
    {
        $strAudit = serialize($audit);
        file_put_contents($this->auditCache, $strAudit);
    }

    public function getCachedAudit()
    {
        if (!$this->hasRunOnce()) {
            throw new \BadMethodCallException('No audit cache found.');
        }

        $strAudit = file_get_contents($this->auditCache);
        return unserialize($strAudit);
    }

    public function addLockFile($path)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('The lock file "%s" does not exist.', $path));
        }

        $this->lockFiles[] = $path;
    }

    public function getLockFiles()
    {
        return $this->lockFiles;
    }
}