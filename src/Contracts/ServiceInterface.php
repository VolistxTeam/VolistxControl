<?php

namespace Volistx\Control\Contracts;

use Volistx\Control\Conns\Status;
use Volistx\Control\Conns\Subscription;

interface ServiceInterface
{
    public function boot();

    public function subscription() : Subscription;

    public function status() : Status;
}