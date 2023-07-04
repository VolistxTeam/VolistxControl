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
}
