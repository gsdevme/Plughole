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
     * @return Stdlib\SocketStatus|null
     */
    public function getStatus();
}
