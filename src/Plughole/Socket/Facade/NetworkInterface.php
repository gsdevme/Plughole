<?php

namespace Plughole\Socket\Facade;

interface NetworkInterface
{
    /**
     * fsockopen — Open Internet or Unix domain socket connection
     *
     * @param      $hostname
     * @param      $port
     * @param null $errno
     * @param null $error
     * @param null $timeout
     *
     * @return resource|false
     */
    public function fsockopen($hostname, $port = -1, &$errno = null, &$error = null, $timeout = null);

    /**
     * Retrieves header/meta data from streams/file pointers
     *
     * @param $resource
     *
     * @return array|null
     */
    public function socketGetStatus($resource);
}
