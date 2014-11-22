<?php

namespace Oneup\SecurityAdvisory;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Post\PostFile;

class CheckRunner
{
    protected $guzzle;

    public function __construct()
    {
        $this->guzzle = new Client();
    }

    public function run()
    {
        $request = $this->guzzle->createRequest('POST', 'https://security.sensiolabs.org/check_lock', [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'body' => [
                'lock' => fopen(TL_ROOT  . '/composer/composer.lock', 'r')
            ]
        ]);

        return $this->guzzle->send($request);
    }
}