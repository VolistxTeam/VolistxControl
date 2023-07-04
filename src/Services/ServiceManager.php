<?php

namespace Volistx\Control\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Volistx\Control\Connections\AdminLog;
use Volistx\Control\Connections\PersonalToken;
use Volistx\Control\Connections\Plan;
use Volistx\Control\Connections\Status;
use Volistx\Control\Connections\Subscription;
use Volistx\Control\Connections\User;
use Volistx\Control\Connections\UserLog;

class ServiceManager
{
    /**
     * Driver config
     */
    protected array $config;

    protected Client $client;

    /**
     * Create a new service instance.
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;

        $this->client = new Client([
            'base_uri' => ($this->config('secure') ? 'https' : 'http') . '://' . $this->config('base_uri') . '/sys-bin/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config('access_key'),
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function config($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    public function status(): Status
    {
        return new Status($this->client);
    }

    public function user(): User
    {
        return new User($this->client);
    }

    public function subscription($user_id): Subscription
    {
        return new Subscription($this->client, $user_id);
    }

    public function personalToken($user_id): PersonalToken
    {
        return new PersonalToken($this->client, $user_id);
    }

    public function adminLog(): AdminLog
    {
        return new AdminLog($this->client);
    }

    public function userLog(): UserLog
    {
        return new UserLog($this->client);
    }

    public function plan(): Plan
    {
        return new Plan($this->client);
    }
}
