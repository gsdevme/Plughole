<?php

namespace Plughole\Socket\Facade;

interface NetworkInterface
{
    public function fsocketopen($hostname, $port = -1, &$errno, &$error, $timeout = null);
}
