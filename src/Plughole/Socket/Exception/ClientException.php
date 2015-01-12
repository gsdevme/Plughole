<?php

namespace Plughole\Socket\Exception;

class ClientException extends \Exception
{
    /* Operation time out is error code 60 */
    const ERROR_OPERATION_TIMEOUT = 60;
}
