<?php

namespace Volistx\Control\Contracts;

use Volistx\Control\Connections\Status;
use Volistx\Control\Connections\Subscription;
use Volistx\Control\Connections\User;

interface ServiceInterface
{
    public function boot();

    public function status() : Status;

    public function user() : User;
}