<?php

namespace Volistx\Control\Services;

use GuzzleHttp\Client;
use Volistx\Control\Connections\AdminLog;
use Volistx\Control\Connections\PersonalToken;
use Volistx\Control\Connections\Plan;
use Volistx\Control\Connections\Status;
use Volistx\Control\Connections\Subscription;
use Volistx\Control\Connections\User;
use Volistx\Control\Connections\UserLog;

class BasicService extends AbstractService
{
    public function boot()
    {
        $this->client = new Client([
            'base_uri' => ($this->config('secure') ? 'https' : 'http').'://'.$this->config('base_uri').'/sys-bin/',
            'headers' => [
                'Authorization' => 'Bearer '.$this->config('access_key'),
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function status(): Status
    {
        return new Status($this->client);
    }

    public function user(): User
    {
        return new User($this->client);
    }

    public function Subscription($user_id): Subscription
    {
        return new Subscription($this->client, $user_id);
    }

    public function PersonalToken($user_id): PersonalToken
    {
        return new PersonalToken($this->client, $user_id);
    }

    public function AdminLog(): AdminLog
    {
        return new AdminLog($this->client);
    }

    public function UserLog(): UserLog
    {
        return new UserLog($this->client);
    }

    public function Plan(): Plan
    {
        return new Plan($this->client);
    }
}
