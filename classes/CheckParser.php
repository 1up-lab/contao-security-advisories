<?php

namespace Oneup\SecurityAdvisory;

class CheckParser
{
    public function isVulnerable($response)
    {
        $response = json_decode($response);

        return count($response) !== 0;
    }
}