<?php

namespace Oneup\SecurityAdvisory\Audit;

class Audit
{
    protected $vulnerabilities;

    public function __construct(array $vulnerabilities = [])
    {
        $this->vulnerabilities = $vulnerabilities;
    }

    public function addResponse($response)
    {
        // Decode and get it as an array instead of stdClass
        $response = json_decode($response, true);

        $vulnerabilities = [];
        foreach ($response as $key => $vulnerability) {
            $data = [
                'name' => $key,
                'version' => $vulnerability['version'],
                'advisories' => array_values($vulnerability['advisories']),
            ];

            $vulnerabilities[] = $data;
        }

        $this->vulnerabilities = $vulnerabilities;
    }

    public function isVulnerable()
    {
        return count($this->vulnerabilities) > 0;
    }

    public function getVulnerabilities()
    {
        return $this->vulnerabilities;
    }
}
