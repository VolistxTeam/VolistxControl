<?php

namespace Volistx\Control\Connections;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Volistx\Control\Helpers\Messages;
use Volistx\Validation\Traits\HasKernelValidations;

class UserModule
{
    protected Client $client;
    protected string $user_id;

    use HasKernelValidations;

    public string $id;
    public bool $is_active;
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