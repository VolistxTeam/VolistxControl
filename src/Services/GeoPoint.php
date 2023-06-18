<?php

namespace Volistx\Control\Services;

use GuzzleHttp\Client;
use Volistx\Control\Conns\Status;
use Volistx\Control\Conns\Subscription;

class GeoPoint extends AbstractService
{
    protected $client;

    /**
     * The "booting" method of the service.
     *
     * @return void
     */
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

    public function subscription() {
        return new Subscription($this->client);
    }

    public function status() {
        return new Status($this->client);
    }
}