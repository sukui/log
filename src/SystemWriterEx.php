<?php

namespace ZanPHP\Log;

use ZanPHP\ConnectionPool\ConnectionEx;
use ZanPHP\ConnectionPool\TCP\TcpClientEx;

class SystemWriterEx implements LogWriter
{
    private $conn;

    public function __construct(ConnectionEx $conn)
    {
        $this->conn = $conn;
    }

    public function write($log)
    {
        try {
            $tcpClient = new TcpClientEx($this->conn);
            yield $tcpClient->send($log);
        } catch (\Throwable $t) {
            echo_exception($t);
        } catch (\Exception $e) {
            echo_exception($e);
        }
    }
}