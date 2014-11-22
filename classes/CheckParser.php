<?php

namespace Oneup\SecurityAdvisory;

class CheckParser
{
    public function isVulnerable($response)
    {
        // Decode and get it as an array instead of stdClass
        $response = json_decode($response);
        $response = (array) $response;

        return count($response) !== 0;
    }

    public function parse($response)
    {
        // Decode and get it as an array instead of stdClass
        $response = json_decode($response, true);

        $vulnerabilities = [];

        foreach ($response as $key => $vulnerability) {
            $data = [
                'name' => $key,
                'version' => $vulnerability['version'],
                'advisories' => array_values($vulnerability['advisories'])
            ];

            $vulnerabilities[] = $data;
        }

        return $vulnerabilities;
    }
}