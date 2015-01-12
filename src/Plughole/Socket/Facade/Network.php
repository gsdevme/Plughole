<?php

namespace Plughole\Socket\Facade;

class Network implements NetworkInterface
{
    /**
     * @param $hostname
     * @param $port
     * @param $errno
     * @param $error
     * @param null $timeout
     * @return resource
     */
    public function fsocketopen($hostname, $port = -1, &$errno = null, &$error = null, $timeout = null)
    {
        if ($timeout === null) {
            return @fsockopen($hostname, $port, $errno, $error);
        }

        return @fsockopen($hostname, $port, $errno, $error, $timeout);
    }
}
