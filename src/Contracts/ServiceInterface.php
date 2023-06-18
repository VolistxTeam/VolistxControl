<?php

namespace Volistx\Control\Contracts;

interface ServiceInterface
{
    public function boot();

    public function subscription();

    public function status();
}