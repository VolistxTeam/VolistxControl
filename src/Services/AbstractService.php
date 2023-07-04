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

abstract class AbstractService
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

        $this->boot();
    }

    /**
     * The "booting" method of the service.
     *
     * @return void
     */
    public function boot()
    {
        //
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
