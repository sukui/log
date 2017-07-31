<?php

namespace Zan\Framework\Sdk\Log;

use Zan\Framework\Foundation\Exception\System\InvalidArgumentException;

class Log
{
    /**
     * @param $key
     * @return BlackholeLogger|FileLogger|SystemLogger
     * @throws InvalidArgumentException
     */
    public static function make($key)
    {

    }
}
