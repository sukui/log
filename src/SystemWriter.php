<?php

namespace ZanPHP\Log;

use InvalidArgumentException;
use ZanPHP\ConnectionPool\Driver\Syslog;

class SystemWriter implements LogWriter
{
    private $conn;

    public function __construct($conn)
    {
        if (!($conn instanceof Syslog) && !($conn instanceof \swoole_client)) {
            throw new InvalidArgumentException('log connection must be instanceof Syslog or \swoole_client.');
        }
        $this->conn = $conn;
    }

    public function write($log)
    {
        yield $this->conn->send($log);
    }
}
