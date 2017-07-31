<?php

namespace Zan\Framework\Sdk\Log;

/**
 * Class SkynetLogger
 * @package Zan\Framework\Sdk\Log
 *
 * 日志格式规范：
 * 消息头+ “|”+ 消息体，消息头之间用“,”分割，消息体由业务自定义
 * 消息头如下结构：
 *
 * 消息头字段        类型     说明
 * appName          String	应用名
 * compress         String	body是否压缩， 0：不压缩，1压缩
 * exceptionClass   String	异常类名
 * hostname         String	主机名称
 * ipAddress        String	ip
 * level            String
 * logindex         String	日志分类
 * magic data	    String	魔鬼数字:0xsky，过滤垃圾数据
 * timeStamp        String	时间戳
 * topic            String	topic
 * version          String	版本号
 *
 */
class SkynetLogger extends SystemLogger
{
    const MAGIC_DATA = "0XSKY";

    const VERSION = "1.0";

    const TOPIC_PREFIX= "skynet";

    const DEFAULT_GROUP = "flume";


    public function __construct(array $config)
    {

    }

    public function format($level, $message, $context)
    {

    }
}
