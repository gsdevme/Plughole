<?php

namespace Plughole\Socket;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testClientConnect()
    {
        $hostname = 'tcp://localhost';
        $port     = 666;
        $timeout  = 60;

        $network = $this->networkFSocketOpenFactory($hostname, $port, $timeout, $this->createStreamResource());

        $client = new Client($hostname, $port, $timeout, $network);
        $result = $client->connect();

        $this->assertEquals(true, $result);
    }

    public function testErrorBeforeConnectCall()
    {
        $hostname = 'tcp://localhost';
        $port     = 666;
        $timeout  = 60;

        $network = $this->networkFSocketOpenFactory($hostname, $port, $timeout, $this->returnCallback(function ($hostname, $port, &$errorNumber, &$error, $timeout) {
            $errorNumber = 0;
            $error = 'Error before connect()';

            return false;
        }), true);

        $this->setExpectedException('Plughole\Socket\Exception\ProblemInitializingSocketException');

        $client = new Client($hostname, $port, $timeout, $network);
        $result = $client->connect();
    }

    public function testTimeout()
    {
        $hostname = 'tcp://localhost';
        $port     = 666;
        $timeout  = 60;

        $network = $this->networkFSocketOpenFactory($hostname, $port, $timeout, $this->returnCallback(function ($hostname, $port, &$errorNumber, &$error, $timeout) {
            $errorNumber = 60;
            $error = 'Operation timed out';

            return false;
        }), true);

        $this->setExpectedException('Plughole\Socket\Exception\TimeoutException', 'Operation timed out');

        $client = new Client($hostname, $port, $timeout, $network);
        $result = $client->connect();
    }

    public function testFallbackException()
    {
        $hostname = 'tcp://localhost';
        $port     = 666;
        $timeout  = 60;

        $network = $this->networkFSocketOpenFactory($hostname, $port, $timeout, false);

        $this->setExpectedException('Plughole\Socket\Exception\ClientException');

        $client = new Client($hostname, $port, $timeout, $network);
        $result = $client->connect();
    }

    /**
     * This is used to create a resource type object to return for the mock
     *
     * @return resource
     */
    private function createStreamResource()
    {
        return fopen('php://memory', 'r');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getNetworkMock()
    {
        return $this->getMock('Plughole\Socket\Facade\NetworkInterface', [
            'fsocketopen',
        ], [], 'Network');
    }

    private function networkFSocketOpenFactory($hostname, $port, $timeout, $return, $callback = false)
    {
        $mock = $this->getNetworkMock();

        $builder = $mock->expects($this->once())
            ->method('fsocketopen')
            ->with(
                $hostname,
                $port,
                $this->anything(),
                $this->anything(),
                $timeout
            );

        if ($callback === false) {
            $builder->willReturn($return);
        } else {
            $builder->will($return);
        }

        return $mock;
    }
}
