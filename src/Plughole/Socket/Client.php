<?php

namespace Plughole\Socket;

use Plughole\Socket\Exception\ClientException;
use Plughole\Socket\Exception\ProblemInitializingSocketException;
use Plughole\Socket\Exception\TimeoutException;
use Plughole\Socket\Facade\NetworkInterface;

class Client implements ClientInterface
{
    private $network;
    private $hostname;
    private $port;
    private $timeout;
    private $resource;
    private $errorNumber;
    private $error;

    /**
     * @param                  $hostname
     * @param                  $port
     * @param null             $timeout
     * @param NetworkInterface $network (only here for unit tests)
     */
    public function __construct($hostname, $port, $timeout = null, NetworkInterface $network = null)
    {
        $this->hostname = $hostname;
        $this->port     = $port;
        $this->timeout  = $timeout;

        if ($network === null) {
            $network = new Facade\Network();
        }

        $this->network = $network;
    }

    /**
     * @inheritdoc
     */
    public function connect()
    {
        $this->resource = $this->network->fsockopen(
            $this->hostname,
            $this->port,
            $this->errorNumber,
            $this->error,
            $this->timeout
        );

        if ((is_resource($this->resource)) && (get_resource_type($this->resource) === self::NETWORK_STREAM_RESOURCE)) {
            return true;
        }

        $this->handleException();
    }

    /**
     * Handle the errorNumber & error to provide a meaningful exception
     *
     * @throws ClientException
     * @throws ProblemInitializingSocketException
     * @throws TimeoutException
     */
    private function handleException()
    {
        if ($this->errorOccurredBeforeConnectCall()) {
            throw new ProblemInitializingSocketException($this->error);
        }

        if ($this->errorNumber === ClientException::ERROR_OPERATION_TIMEOUT) {
            throw new TimeoutException($this->error, $this->errorNumber);
        }

        throw new ClientException($this->error, $this->errorNumber);
    }

    /**
     * If the value returned in errno is 0 and the function returned FALSE,
     * it is an indication that the error occurred before the connect() call.
     * This is most likely due to a problem initializing the socket.
     *
     * Taken from: http://php.net/manual/en/function.fsockopen.php
     */
    private function errorOccurredBeforeConnectCall()
    {
        return (($this->resource === false) && ($this->errorNumber === 0));
    }

    /**
     * @inheritdoc
     */
    public function close()
    {

    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        $status = $this->network->socketGetStatus($this->resource);

        if ($status === null) {
            return null;
        }

        return new Stdlib\SocketStatus($status);
    }
}
