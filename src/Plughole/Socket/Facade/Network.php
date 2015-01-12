<?php

namespace Plughole\Socket\Facade;

class Network implements NetworkInterface
{
    /**
     * @inheritdoc
     */
    public function fsockopen($hostname, $port = -1, &$errno = null, &$error = null, $timeout = null)
    {
        if ($timeout === null) {
            return @fsockopen($hostname, $port, $errno, $error);
        }

        return @fsockopen($hostname, $port, $errno, $error, $timeout);
    }

    /**
     * @inheritdoc
     */
    public function socketGetStatus($resource)
    {
        return socket_get_status($resource);
    }
}
