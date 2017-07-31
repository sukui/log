<?php

namespace ZanPHP\Log;

use ZanPHP\ConnectionPool\ConnectionEx;
use ZanPHP\Contracts\ConnectionPool\ConnectionManager;
use ZanPHP\Exception\ZanException;

class SystemLogger extends BaseLogger
{
    const TOPIC_PREFIX = 'log';
    protected $priority;
    protected $hostname;
    protected $ip;
    protected $server;
    protected $pid;
    protected $conn;
    protected $connectionConfig;

    public function __construct($config)
    {
        parent::__construct($config);

        $this->connectionConfig = 'syslog.' . str_replace('/', '', $this->config['path']);
        $this->priority = LOG_LOCAL3 + LOG_INFO;
        $this->hostname = getenv('hostname');
        $this->ip = getenv('ip');
        $this->server = $this->hostname . '/' . $this->ip;
        $this->pid = getenv('pid');
    }

    public function init()
    {
        $connectionManager = make(ConnectionManager::class);
        /** @var ConnectionManager conn */
        $this->conn = (yield $connectionManager->get($this->connectionConfig));
        if ($this->conn instanceof ConnectionEx) {
            $this->writer = new SystemWriterEx($this->conn);
        } else {
            $this->writer = new SystemWriter($this->conn);
        }
    }

    public function format($level, $message, $context)
    {
        // 业务需求：flume 系统识别的是 warn
        $level = ($level === 'warning') ? 'warn' : $level;

        $header = $this->buildHeader($level);
        $topic = $this->buildTopic();
        $body = $this->buildBody($level, $message, $context);
        return "{$header}topic=$topic $body\n";
    }

    protected function doWrite($log)
    {
        try {
            yield $this->init();
            yield $this->getWriter()->write($log);
        } catch (\Throwable $t) {
            echo_exception($t);
        } catch (\Exception $ex) {
            echo_exception($ex);
        }
    }

    private function buildHeader($level)
    {
        $time = date('Y-m-d H:i:s');
        return "<{$this->priority}>{$time} {$this->server} {$level}[{$this->pid}]: ";
    }

    private function buildTopic()
    {
        $config = $this->config;
        if ($config['module'] == 'soa-framework') {
            $result = SystemLogger::TOPIC_PREFIX . '.soa-framework.default';
        } else {
            $result = SystemLogger::TOPIC_PREFIX . '.' . $config['app'] . '.' . $config['module'];
        }
        return $result;
    }

    private function buildBody($level, $message, array $context = [])
    {
        $detail = [];
        if (isset($context['exception'])) {
            $e = $context['exception'];
            if ($e instanceof \Throwable || $e instanceof \Exception) {
                $e = $context['exception'];
                $detail['error'] = $this->formatException($e);
                $context['exception_metadata'] = $e instanceof ZanException ? $e->getMetadata() : [];
                unset($context['exception']);
            }
        }

        $detail['extra'] = $context;
        $result = [
            'platform' => 'php',
            'app' => $this->config['app'],
            'module' => $this->config['module'],
            'level' => $level,
            'tag' => $message,
            'detail' => $detail
        ];

        if ($this->config['module'] == 'soa-framework') {
            $result['app'] = 'soa-framework';
            $result['module'] = 'default';
        }

        // json_encode这里会转义"\n", flume 日志 会按 "\n" 拆分
        return json_encode($result);
    }

}
