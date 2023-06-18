<?php

namespace Volistx\Control\Conns;

use GuzzleHttp\Client;

class Subscription {
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}