<?php

namespace Volistx\Control\Services;

use GuzzleHttp\Client;

class UserPoint extends AbstractService
{
    public function boot()
    {
        $this->client = new Client([
            'base_uri' => ($this->config('secure') ? 'https' : 'http') . '://' . $this->config('base_uri') . '/sys-bin/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config('access_key'),
                'Accept' => 'application/json',
            ],
        ]);
    }
}