<?php

namespace Plughole\Socket;

interface ClientInterface
{
    const NETWORK_STREAM_RESOURCE = 'stream';

    /**
     * Connects to the client
     *
     * @return bool
     */
    public function connect();

    /**
     * Closes the connection to the client
     *
     * @return void
     */
    public function close();

    /**
     * Retrieves header/meta data from the connection
     *
     * @return bool
     */
    public function status();

    /**
     * Enables the socket to block waiting for a response
     *
     * @return bool
     */
    public function enableBlocking();

    /**
     * Disables the socket to block
     * @return bool
     */
    public function disableBloocking();
}