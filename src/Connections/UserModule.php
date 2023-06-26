<?php

namespace Volistx\Control\Connections;

use GuzzleHttp\Client;

class UserModule
{
    public string $id;
    public bool $is_active;
    protected Client $client;
    protected string $user_id;

    public function __construct(Client $client, string $user_id, bool $is_active)
    {
        $this->client = $client;
        $this->user_id = $user_id;
        $this->is_active = $is_active;
    }

    public function subscription(): Subscription
    {
        return new Subscription($this->client, $this->user_id);
    }
}