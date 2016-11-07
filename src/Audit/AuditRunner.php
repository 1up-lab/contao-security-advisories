<?php

namespace Oneup\SecurityAdvisory\Audit;

use GuzzleHttp\Client;

class AuditRunner extends \System
{
    protected $lockFiles;
    protected $auditCache;
    protected $guzzle;

    public function __construct()
    {
        parent::__construct();

        $this->lockFiles = [];
        $this->auditCache = TL_ROOT . '/system/cache/security-audit.json';
        $this->guzzle = new Client([
            'base_uri' => 'https://security.sensiolabs.org',
        ]);
    }

    public function run()
    {
        $audit = new Audit();

        foreach ($this->lockFiles as $lockFile) {
            $response = $this->guzzle->request('POST', '/check_lock', [
                'headers' => ['Accept' => 'application/json'],
                'body' => ['lock' => fopen($lockFile, 'r')]
            ]);

            // get actual response body
            $responseBody =$response->getBody()->getContents();

            // add body to audit
            $audit->addResponse($responseBody);
        }

        $this->cacheAudit($audit);

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['securityAuditPerformed']) && is_array($GLOBALS['TL_HOOKS']['securityAuditPerformed']))
        {
            foreach ($GLOBALS['TL_HOOKS']['securityAuditPerformed'] as $callback)
            {
                $this->import($callback[0]);
                $this->$callback[0]->$callback[1]($audit);
            }
        }

        return $audit;
    }

    public function hasRunOnce()
    {
        return file_exists($this->auditCache);
    }

    public function cacheAudit(Audit $audit)
    {
        $strAudit = json_encode($audit->getVulnerabilities());
        file_put_contents($this->auditCache, $strAudit);
    }

    public function getCachedAudit()
    {
        if (!$this->hasRunOnce()) {
            throw new \BadMethodCallException('No audit cache found.');
        }

        $strAudit = file_get_contents($this->auditCache);
        $vulnerabilites = json_decode($strAudit, true);

        return new Audit($vulnerabilites);
    }

    public function getCacheLastModified()
    {
        if (!$this->hasRunOnce()) {
            throw new \BadMethodCallException('No audit cache found.');
        }

        return filemtime($this->auditCache);
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
