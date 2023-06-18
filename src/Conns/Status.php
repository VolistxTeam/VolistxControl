<?php

namespace Volistx\Control\Conns;

use GuzzleHttp\Client;

class Status {

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function ping() {
        try {
            $request = $this->client->get('ping');

            return json_decode($request->getBody()->getContents());
        } catch (\Exception) {
            return null;
        }
    }

    public function timestamp() {
        try {
            $request = $this->client->get('timestamp');

            return $request->getBody()->getContents();
        } catch (\Exception) {
            return null;
        }
    }
}