<?php

namespace Plughole\Socket\Stdlib;

class SocketStatus
{
    const KEY_TIMED_OUT    = 'timed_out';
    const KEY_BLOCKED      = 'blocked';
    const KEY_EOF          = 'eof';
    const KEY_UNREAD_BYTES = 'unread_bytes';
    const KEY_STREAM_TYPE  = 'stream_type';
    const KEY_WRAPPER_TYPE = 'wrapper_type';
    const KEY_MODE         = 'mode';
    const KEY_SEEKABLE     = 'seekable';
    const KEY_URI          = 'uri';

    public $timedOut;
    public $blocked;
    public $eof;
    public $unreadBytes;
    public $streamType;
    public $wrapperType;
    public $mode;
    public $seekable;
    public $uri;

    public function __construct(array $status)
    {
        $this->timedOut    = $status[self::KEY_TIMED_OUT];
        $this->blocked     = $status[self::KEY_BLOCKED];
        $this->eof         = $status[self::KEY_EOF];
        $this->unreadBytes = $status[self::KEY_UNREAD_BYTES];
        $this->streamType  = $status[self::KEY_STREAM_TYPE];
        $this->wrapperType = $status[self::KEY_WRAPPER_TYPE];
        $this->mode        = $status[self::KEY_MODE];
        $this->seekable    = $status[self::KEY_SEEKABLE];
        $this->uri         = $status[self::KEY_URI];
    }
}
