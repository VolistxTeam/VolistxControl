<?php

namespace Volistx\Control\Services;

use GuzzleHttp\Client;
use Volistx\Control\Connections\Status;
use Volistx\Control\Connections\Subscription;
use Volistx\Control\Connections\User;
use Volistx\Control\Contracts\ServiceInterface;

class GeoPoint extends AbstractService
{
    protected $client;

    public function boot()
    {
        $this->client = new Client([
            'base_uri' => ($this->config('secure') ? 'https' : 'http') . '://volistx-framework.test/sys-bin/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config('access_key'),
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function status(): Status
    {
        return new Status($this->client);
    }

    public function user() : User
    {
        return new User($this->client);
    }
}