<?php

namespace Plughole\Socket\Facade;

interface NetworkInterface
{
    /**
     * fsockopen — Open Internet or Unix domain socket connection
     *
     * @param $hostname
     * @param $port
     * @param null $errno
     * @param null $error
     * @param null $timeout
     * @return mixeda
     */
    public function fsockopen($hostname, $port = -1, &$errno = null, &$error = null, $timeout = null);

    public function socketGetStatus($resource);
}
